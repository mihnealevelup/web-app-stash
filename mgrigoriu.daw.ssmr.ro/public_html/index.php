<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mihnea Level Up - Web App Dev</title>
    <style>
        body {
            background-color: #0f0f0f;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        p { color: #888; margin-bottom: 2rem; }
        .card {
            background: #1e1e1e;
            padding: 2rem;
            border-radius: 12px;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            max-width: 400px;
            transition: transform 0.2s;
        }
        .card:hover { transform: translateY(-5px); border-color: #d4af37; }
        .btn {
            display: inline-block;
            background-color: #d4af37;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover { background-color: #f1c40f; }
        .status-dot {
            height: 10px; width: 10px; background-color: #00b894;
            border-radius: 50%; display: inline-block; margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Web App Dev Projects</h1>
    <p>For cloudy days</p>

    <div style="margin-top: 1.5rem; text-align: left;">
        <h3 style="border-bottom: 1px solid #444; padding-bottom: 10px;">Projects</h3>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
            <span><span class="status-dot"></span> Cinema-Forge</span>
            <a href="/cinema" class="btn">Check it out</a>
        </div>
        <p style="font-size: 0.85rem; margin-top: 5px;">Platform for a movie production studio (WIP).</p>
    </div>
</div>
</body>
</html>