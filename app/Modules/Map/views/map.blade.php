<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Grid</title>
    <style>
        #grid-container {
            margin-left: 125px;
            display: grid;
            /*grid-template-columns: repeat(10, 1fr); !* Change the number of columns as needed *!*/
            /*grid-template-rows: repeat(10, 1fr); !* Change the number of rows as needed *!*/
            gap: 0px;
            width: 800px;
            height: 700px;
            padding: 10px;
            box-sizing: border-box;
            transform: rotate3d(7, -3, 5, 60deg);
        }

        .grid-item {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="grid-container"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridContainer = document.getElementById('grid-container');

        function createGrid(rows, cols) {
            gridContainer.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
            gridContainer.style.gridTemplateRows = `repeat(${rows}, 1fr)`;
            for (let i = 0; i < rows * cols; i++) {
                const gridItem = document.createElement('div');
                gridItem.classList.add('grid-item');
                gridContainer.appendChild(gridItem);
            }
        }

        function addTextToGrid(text, row, col, rowSpan = 1, colSpan = 1, backgroundColor = 'white') {
            const gridItem = document.createElement('div');
            gridItem.classList.add('grid-item');
            gridItem.textContent = text;
            gridItem.style.gridRowStart = row;
            gridItem.style.gridColumnStart = col;
            gridItem.style.gridRowEnd = `span ${rowSpan}`;
            gridItem.style.gridColumnEnd = `span ${colSpan}`;
            gridItem.style.backgroundColor = backgroundColor;
            gridContainer.appendChild(gridItem);
        }

        createGrid(26, 22);

        // bear
        addTextToGrid('Bear Trap', 13, 9, 3, 3, 'green');
        addTextToGrid('B', 13, 12, 1, 1, 'blue');
        addTextToGrid('B', 16, 9, 1, 1, 'blue');
        addTextToGrid('B', 16, 12, 1, 1, 'blue');

        // banners
        addTextToGrid('B', 2, 5, 1, 1, 'blue');
        addTextToGrid('B', 9, 5, 1, 1, 'blue');
        addTextToGrid('B', 6, 12, 1, 1, 'blue');
        addTextToGrid('B', 16, 2, 1, 1, 'blue');
        addTextToGrid('B', 23, 2, 1, 1, 'blue');
        addTextToGrid('B', 23, 9, 1, 1, 'blue');
        addTextToGrid('B', 23, 16, 1, 1, 'blue');
        addTextToGrid('B', 9, 18, 1, 1, 'blue');
        addTextToGrid('B', 16, 18, 1, 1, 'blue');

        // mines
        addTextToGrid('', 1, 9, 2, 2, 'black');
        addTextToGrid('', 8, 16, 2, 2, 'black');
        addTextToGrid('', 22, 12, 2, 2, 'black');

        // Example of adding text to the grid
        // addTextToGrid('Hello', 1, 1);
        // addTextToGrid('World', 2, 2, 2, 2); // Spans 2 rows and 2 columns
        // addTextToGrid('Dynamic', 4, 4, 1, 3); // Spans 1 row and 3 columns
    });
</script>
</body>
</html>
