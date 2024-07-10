<style>
    #grid-container {
        display: grid;
        gap: 0;
        width: {{ $width ?? '1000px' }};
        height: {{ $height ?? '1000px' }};
        padding: 10px;
        box-sizing: border-box;
        transition-duration: 1s;
    }

    .grid-item {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #ccc;
        background-color: #f0f0f0;
        font-size: 13px;
        text-align: center;
    }

    .grid-item span {
        transform: rotate(-30deg);
    }
</style>

<div>
    <button onclick="togglePerspective();" class="primary">Toggle perspective</button>
    <div id="grid-container"></div>
</div>

<script>
    function togglePerspective() {
        const element = document.getElementById('grid-container');
        element.style.transform = element.style.transform === '' ? 'rotate3d(7, -3, 5, 60deg)' : '';
    }

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

        function addTextToGrid(
            text, row, col,
            rowSpan = 1,
            colSpan = 1,
            backgroundColor = 'white',
            url = null
        ) {
            const gridItem = document.createElement('div');
            gridItem.classList.add('grid-item');
            gridItem.style.gridRowStart = row;
            gridItem.style.gridColumnStart = col;
            gridItem.style.gridRowEnd = `span ${rowSpan}`;
            gridItem.style.gridColumnEnd = `span ${colSpan}`;
            gridItem.style.backgroundColor = backgroundColor;

            if (url) {
                gridItem.onclick = () => document.location = url;
            }

            const span = document.createElement('span');
            span.textContent = text;
            gridItem.appendChild(span);

            gridContainer.appendChild(gridItem);
        }

        createGrid(26, 22);
        togglePerspective();

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

            addTextToGrid('{{ $item->nickname }}', {{ $item->row }}, {{ $item->col }}, 2, 2, '#5C9B3E', '{{ $item->url }}');

        @endforeach
    });
</script>
