  //CANVAS
    // Get the canvas element and its context
    const canvas = document.getElementById('myCanvas');
    displayWindowSize()

    function displayWindowSize() {
        canvas.width = (window.innerWidth / 100) * 40;
        canvas.height = (window.innerWidth / 100) * 30;
    }

    // Attaching the event listener function to window's resize event
    window.addEventListener("resize", displayWindowSize);


    const ctx = canvas.getContext('2d');

    // Set up variables to store the drawing state
    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;

    // Set the pen style properties
    ctx.lineWidth = 5;
    ctx.lineCap = 'round';
    ctx.strokeStyle = 'black';

    // Event listeners for drawing
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas
        .addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Function to start drawing
    function startDrawing(e) {
        console.log(e)
        isDrawing = true;
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }

    // Function to draw when the mouse is moved
    function draw(e) {
        if (!isDrawing) return;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }

    // Function to stop drawing
    function stopDrawing() {
        isDrawing = false;
    }

    // Clear the canvas
    function clearCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Additional functionality for clearing the canvas
    document.addEventListener('keydown', function(event) {
        if (event.key === 'c') {
            clearCanvas();
        }
    });