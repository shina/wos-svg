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

        .grid-item span {
            transform: rotate(-30deg);
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
            // gridItem.textContent = text;
            gridItem.style.gridRowStart = row;
            gridItem.style.gridColumnStart = col;
            gridItem.style.gridRowEnd = `span ${rowSpan}`;
            gridItem.style.gridColumnEnd = `span ${colSpan}`;
            gridItem.style.backgroundColor = backgroundColor;

            const span = document.createElement('span');
            span.textContent = text;
            gridItem.appendChild(span);

            gridContainer.appendChild(gridItem);
        }

        createGrid(26, 22);

        // bear
        addTextToGrid('Bear Trap', 13, 9, 3, 3, '#2D6517');
        addTextToGrid('B', 13, 12, 1, 1, '#3D6FE3');
        addTextToGrid('B', 16, 9, 1, 1, '#3D6FE3');
        addTextToGrid('B', 16, 12, 1, 1, '#3D6FE3');

        // banners
        addTextToGrid('B', 2, 5, 1, 1, '#3D6FE3');
        addTextToGrid('B', 9, 5, 1, 1, '#3D6FE3');
        addTextToGrid('B', 6, 12, 1, 1, '#3D6FE3');
        addTextToGrid('B', 16, 2, 1, 1, '#3D6FE3');
        addTextToGrid('B', 23, 2, 1, 1, '#3D6FE3');
        addTextToGrid('B', 23, 9, 1, 1, '#3D6FE3');
        addTextToGrid('B', 23, 16, 1, 1, '#3D6FE3');
        addTextToGrid('B', 9, 19, 1, 1, '#3D6FE3');
        addTextToGrid('B', 16, 19, 1, 1, '#3D6FE3');

        // mines
        addTextToGrid('', 1, 9, 2, 2, 'black');
        addTextToGrid('', 8, 17, 2, 2, 'black');
        addTextToGrid('', 23, 12, 2, 2, 'black');

        @foreach($items as $item)
            addTextToGrid('{{ $item->nickname }}', {{ $item->row }}, {{ $item->col }}, 2, 2, '#5C9B3E');
        @endforeach
    });
</script>
</body>
</html>
