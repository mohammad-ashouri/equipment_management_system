/**
 * Mutate an array, moving a set of elements into a new index position
 *
 * @param arr Array to modify
 * @param from Start move index
 * @param count Number of elements to move
 * @param to Index where the start element will move to
 */
export function arrayMove(arr, from, count, to) {
    var movers = arr.splice(from, count);
    // Add delete and start to the array, so we can use it for the `apply`
    movers.unshift(0); // splice delete param
    movers.unshift(to < from ? to : to - count + 1); // splice start param
    arr.splice.apply(arr, movers);
}
/**
 * Run finishing activities after one or more columns have been reordered.
 *
 * @param dt DataTable being operated on - must be a single table instance
 */
export function finalise(dt) {
    // Cache invalidation. Always read from the data object rather
    // than reading back from the DOM since it could have been
    // changed by a renderer
    dt.rows().invalidate('data');
    // Redraw the header / footer. Its a little bit of a hack this, as DT
    // doesn't expose the header draw as an API method. It calls state
    // saving, so we don't need to here.
    dt.column(0).visible(dt.column(0).visible());
    dt.columns.adjust();
    // Fire an event so other plug-ins can update
    var order = dt.colReorder.order();
    dt.trigger('columns-reordered', [
        {
            order: order,
            mapping: invertKeyValues(order)
        }
    ]);
}
/**
 * Get the original indexes in their current order
 *
 * @param dt DataTable being operated on - must be a single table instance
 * @returns Original indexes in current order
 */
export function getOrder(dt) {
    return dt.settings()[0].aoColumns.map(function (col) {
        return col._crOriginalIdx;
    });
}
/**
 * Manipulate a header / footer array in DataTables settings to reorder
 * the columns.
 */
export function headerUpdate(structure, map, from, to) {
    var done = [];
    for (var i = 0; i < structure.length; i++) {
        var headerRow = structure[i];
        arrayMove(headerRow, from[0], from.length, to);
        for (var j = 0; j < headerRow.length; j++) {
            var cell = headerRow[j].cell;
            // Only work on a DOM element once, otherwise we risk remapping a
            // remapped value (etc).
            if (done.includes(cell)) {
                continue;
            }
            var indexes = cell.getAttribute('data-dt-column').split(',');
            var mapped = indexes
                .map(function (idx) {
                return map[idx];
            })
                .join(',');
            // Update data attributes for the new column position
            cell.setAttribute('data-dt-column', mapped);
            done.push(cell);
        }
    }
}
/**
 * Setup for ColReorder API operations
 *
 * @param dt DataTable(s) being operated on - might have multiple tables!
 */
export function init(api) {
    // Assign the original column index to a parameter that we can lookup.
    // On the first pass (i.e. when the parameter hasn't yet been set), the
    // index order will be the original order, so this is quite a simple
    // assignment.
    api.columns().iterator('column', function (s, idx) {
        var columns = s.aoColumns;
        if (columns[idx]._crOriginalIdx === undefined) {
            columns[idx]._crOriginalIdx = idx;
        }
    });
}
/**
 * Switch the key value pairing of an index array to be value key (i.e. the old value is now the
 * key). For example consider [ 2, 0, 1 ] this would be returned as [ 1, 2, 0 ].
 *
 *  @param   array arr Array to switch around
 */
export function invertKeyValues(arr) {
    var result = [];
    for (var i = 0; i < arr.length; i++) {
        result[arr[i]] = i;
    }
    return result;
}
/**
 * Move one or more columns from one index to another.
 *
 * This method has a lot of knowledge about how DataTables works internally.
 * If DataTables changes how it handles cells, columns, etc, then this
 * method would need to be updated accordingly.
 *
 * @param dt DataTable being operated on - must be a single table instance
 * @param from Column indexes to move
 * @param to Destination index (starting if multiple)
 */
export function move(dt, from, to) {
    var i, j;
    var settings = dt.settings()[0];
    var columns = settings.aoColumns;
    var newOrder = columns.map(function (col, idx) {
        return idx;
    });
    // The to column in already inside the from column(s) (might be the same)
    // no change required
    if (from.includes(to)) {
        return;
    }
    // A reverse index array so we can look up new indexes from old
    arrayMove(newOrder, from[0], from.length, to);
    var reverseIndexes = invertKeyValues(newOrder);
    // Main column
    arrayMove(columns, from[0], from.length, to);
    // Per row manipulations
    for (i = 0; i < settings.aoData.length; i++) {
        var data = settings.aoData[i];
        // Allow for sparse array
        if (!data) {
            continue;
        }
        var cells = data.anCells;
        // Not yet rendered
        if (!cells) {
            continue;
        }
        // Array of cells
        arrayMove(cells, from[0], from.length, to);
        for (j = 0; j < cells.length; j++) {
            // Reinsert into the document in the new order
            if (data.nTr && cells[j] && columns[j].bVisible) {
                data.nTr.appendChild(cells[j]);
            }
            // Update lookup index
            if (cells[j] && cells[j]._DT_CellIndex) {
                cells[j]._DT_CellIndex.column = j;
            }
        }
    }
    // Per column manipulation
    for (i = 0; i < columns.length; i++) {
        var column = columns[i];
        // Data column sorting
        for (j = 0; j < column.aDataSort.length; j++) {
            column.aDataSort[j] = reverseIndexes[column.aDataSort[j]];
        }
        // Update the column indexes
        column.idx = reverseIndexes[column.idx];
        // Reorder the colgroup > col elements for the new order
        if (column.bVisible) {
            settings.colgroup.append(column.colEl);
        }
    }
    // Header and footer
    headerUpdate(settings.aoHeader, reverseIndexes, from, to);
    headerUpdate(settings.aoFooter, reverseIndexes, from, to);
    // Search - columns
    arrayMove(settings.aoPreSearchCols, from[0], from.length, to);
    // Ordering indexes update - note that the sort listener on the
    // header works out the index to apply on each draw, so it doesn't
    // need to be updated here.
    orderingIndexes(reverseIndexes, settings.aaSorting);
    if (Array.isArray(settings.aaSortingFixed)) {
        orderingIndexes(reverseIndexes, settings.aaSortingFixed);
    }
    else if (settings.aaSortingFixed.pre) {
        orderingIndexes(reverseIndexes, settings.aaSortingFixed.pre);
    }
    else if (settings.aaSortingFixed.post) {
        orderingIndexes(reverseIndexes, settings.aaSortingFixed.pre);
    }
    settings.aLastSort.forEach(function (el) {
        el.src = reverseIndexes[el.src];
    });
    // Fire an event so other plug-ins can update
    dt.trigger('column-reorder', [
        dt.settings()[0],
        {
            from: from,
            to: to,
            mapping: reverseIndexes
        }
    ]);
}
/**
 * Update the indexing for ordering arrays
 *
 * @param map Reverse index map
 * @param order Array to update
 */
export function orderingIndexes(map, order) {
    // Can happen if the order was deleted from a saved state
    if (!order) {
        return;
    }
    for (var i = 0; i < order.length; i++) {
        var el = order[i];
        if (typeof el === 'number') {
            // Just a number
            order[i] = map[el];
        }
        else if ($.isPlainObject(el) && el.idx !== undefined) {
            // New index in an object style
            el.idx = map[el.idx];
        }
        else if (Array.isArray(el) && typeof el[0] === 'number') {
            // The good old fixes length array
            el[0] = map[el[0]];
        }
        // No need to update if in object + .name style
    }
}
/**
 * Take an index array for the current positioned, reordered to what you want
 * them to be.
 *
 * @param dt DataTable being operated on - must be a single table instance
 * @param order Indexes from current order, positioned as you want them to be
 */
export function setOrder(dt, order, original) {
    var changed = false;
    var i;
    if (order.length !== dt.columns().count()) {
        dt.error('ColReorder - column count mismatch');
        return;
    }
    // The order given is based on the original indexes, rather than the
    // existing ones, so we need to translate from the original to current
    // before then doing the order
    if (original) {
        order = transpose(dt, order, 'toCurrent');
    }
    // The API is array index as the desired position, but our algorithm below is
    // for array index as the current position. So we need to invert for it to work.
    var setOrder = invertKeyValues(order);
    // Move columns, one by one with validation disabled!
    for (i = 0; i < setOrder.length; i++) {
        var currentIndex = setOrder.indexOf(i);
        if (i !== currentIndex) {
            // Reorder our switching error
            arrayMove(setOrder, currentIndex, 1, i);
            // Do the reorder
            move(dt, [currentIndex], i);
            changed = true;
        }
    }
    // Reorder complete
    if (changed) {
        finalise(dt);
    }
}
/**
 * Convert the DataTables header structure array into a 2D array where each
 * element has a reference to its TH/TD cell (regardless of spanning).
 *
 * @param structure Header / footer structure object
 * @returns 2D array of header cells
 */
export function structureFill(structure) {
    var filledIn = [];
    for (var row = 0; row < structure.length; row++) {
        filledIn.push([]);
        for (var col = 0; col < structure[row].length; col++) {
            var cell = structure[row][col];
            if (cell) {
                for (var rowInner = 0; rowInner < cell.rowspan; rowInner++) {
                    if (!filledIn[row + rowInner]) {
                        filledIn[row + rowInner] = [];
                    }
                    for (var colInner = 0; colInner < cell.colspan; colInner++) {
                        filledIn[row + rowInner][col + colInner] = cell.cell;
                    }
                }
            }
        }
    }
    return filledIn;
}
/**
 * Convert the index type
 *
 * @param dt DataTable to work on
 * @param idx Index to transform
 * @param dir Transform direction
 * @returns Converted number(s)
 */
export function transpose(dt, idx, dir) {
    var order = dt.colReorder.order();
    var columns = dt.settings()[0].aoColumns;
    if (dir === 'toCurrent' || dir === 'fromOriginal') {
        // Given an original index, want the current
        return !Array.isArray(idx)
            ? order.indexOf(idx)
            : idx.map(function (index) {
                return order.indexOf(index);
            });
    }
    // Given a current index, want the original
    return !Array.isArray(idx)
        ? columns[idx]._crOriginalIdx
        : idx.map(function (index) {
            return columns[index]._crOriginalIdx;
        });
}
/**
 * Validate that a requested move is okay. This includes bound checking
 * and that it won't split colspan'ed cells.
 *
 * @param table API instance
 * @param from Column indexes to move
 * @param to Destination index (starting if multiple)
 * @returns Validation result
 */
export function validateMove(table, from, to) {
    var columns = table.columns().count();
    // Sanity and bound checking
    if (from[0] < to && to < from[from.length]) {
        return false;
    }
    if (from[0] < 0 && from[from.length - 1] > columns) {
        return false;
    }
    if (to < 0 && to > columns) {
        return false;
    }
    // No change - it's valid
    if (from.includes(to)) {
        return true;
    }
    if (!validateStructureMove(table.table().header.structure(), from, to)) {
        return false;
    }
    if (!validateStructureMove(table.table().footer.structure(), from, to)) {
        return false;
    }
    return true;
}
/**
 * For a given structure check that the move is valid.
 * @param structure
 * @param from
 * @param to
 * @returns
 */
export function validateStructureMove(structure, from, to) {
    var header = structureFill(structure);
    var i;
    // Shuffle the header cells around
    for (i = 0; i < header.length; i++) {
        arrayMove(header[i], from[0], from.length, to);
    }
    // Sanity check that the headers are next to each other
    for (i = 0; i < header.length; i++) {
        var seen = [];
        for (var j = 0; j < header[i].length; j++) {
            var cell = header[i][j];
            if (!seen.includes(cell)) {
                // Hasn't been seen before
                seen.push(cell);
            }
            else if (seen[seen.length - 1] !== cell) {
                // Has been seen before and is not the previous cell - validation failed
                return false;
            }
        }
    }
    return true;
}
