<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <style>
        body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f2f2f2;
}

.container {
    position: relative;
    perspective: 800px;
}

.content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotateY(20deg);
    text-align: center;
    padding: 40px;
    background-color: #fff;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    transition: transform 0.5s;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
}

.container:hover .content {
    transform: translate(-50%, -50%) rotateY(0deg);
}

h1 {
    font-size: 2.5em;
    color: #333;
}

p {
    font-size: 1.2em;
    color: #666;
    margin-top: 20px;
}


    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Coming Soon!</h1>
            <p>Our amazing website is under maintenance...</p>
        </div>
        <div class="overlay"></div>
    </div>
</body>
</html>
