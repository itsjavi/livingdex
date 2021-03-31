function UpperCaseFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
}

function CalcImageSrc(num, formSlug) {
  let src = CalcRangeFolder(num) + "/" + String(num).padStart(4, "0")

  if (formSlug) {
    src += "-" + formSlug
  }

  return src + ".png"
}

function CalcRangeFolder(num, zeroPadding = 4, itemsPerFolder = 100) {
  num = parseInt(num)
  let minFolder = null
  let maxFolder = null

  for (let i = 0; i < num + (itemsPerFolder * 2); i += itemsPerFolder) {
    if ((i + itemsPerFolder) >= num) {
      minFolder = (i + 1)
      maxFolder = i + itemsPerFolder
      break
    }
  }

  return String(minFolder).padStart(4, "0") + "-" + String(maxFolder).padStart(4, "0")
}

/**
 * Given the sequential index of the element in a flattened list,
 * calculates the position of the element in a list of grids, given each grid dimensions.
 *
 * @param {number} sequentialIndex
 * @param {number} gridRows
 * @param {number} gridColumns
 * @return {BoxPosition}
 */
function CalcBoxPosition(sequentialIndex, gridRows = 5, gridColumns = 6) {
  let i = -1
  let grid = 0
  let col = 0
  let row = 0
  let debug = "\n"

  while (i < sequentialIndex) {
    // new line
    if ((col + 1) > gridColumns) {
      col = 0
      row++
      debug += "\n"
    } else {
      i++
      if (i === sequentialIndex) {
        debug += " * \n\n"
        break
      }
      debug += " - "
      col++
    }

    // new box
    if ((row + 1) > gridRows) {
      grid++
      row = 0
      col = 0
      debug += "\n\n"
    }
  }

  return {
    box: grid,
    row: row,
    col: col,
    debug: debug,
  }
}

export { UpperCaseFirst, CalcRangeFolder, CalcBoxPosition, CalcImageSrc }
