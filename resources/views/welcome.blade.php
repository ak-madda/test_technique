<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager - Welcome</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .welcome-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }
        .logo {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #667eea;
        }
        .welcome-title {
            color: #2d3748;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .welcome-subtitle {
            color: #718096;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }
        .feature {
            background: #f7fafc;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .feature h4 {
            margin: 0 0 0.5rem 0;
            color: #2d3748;
        }
        .feature p {
            margin: 0;
            color: #718096;
            font-size: 0.9rem;
        }
        .cta-buttons {
            margin-top: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: #667eea;
        }
        .btn-primary:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
        }
        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }
        .tech-stack {
            margin-top: 2rem;
            padding: 1rem;
            background: #edf2f7;
            border-radius: 8px;
        }
        .tech-stack h4 {
            margin: 0 0 1rem 0;
            color: #2d3748;
        }
        .tech-tags {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .tech-tag {
            background: #667eea;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="welcome-container">
        <div class="logo">✅</div>
        <h1 class="welcome-title">Task Manager Pro</h1>
        <p class="welcome-subtitle">
            Organize your tasks efficiently with our powerful task management system. 
            Create, track, and complete your tasks with ease.
        </p>

        <div class="features">
            <div class="feature">
                <h4>📋 Create Tasks</h4>
                <p>Add new tasks with titles, descriptions, and due dates</p>
            </div>
            <div class="feature">
                <h4>✅ Track Progress</h4>
                <p>Monitor your task completion status in real-time</p>
            </div>
            <div class="feature">
                <h4>📅 Due Dates</h4>
                <p>Set and manage deadlines for your tasks</p>
            </div>
            <div class="feature">
                <h4>🎯 Categories</h4>
                <p>Organize tasks by categories and priorities</p>
            </div>
        </div>

        <div class="cta-buttons">
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">Get Started</a>
           <!-- <a href="#" class="btn btn-secondary">Sign In</a> -->
            <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
        </div>

        <div class="tech-stack">
            <h4>Built With:</h4>
            <div class="tech-tags">
                <span class="tech-tag">Laravel {{ app()->version() }}</span>
                <span class="tech-tag">PHP {{ phpversion() }}</span>
                <span class="tech-tag">MySQL</span>
                <span class="tech-tag">Vue.js</span>
                <span class="tech-tag">Tailwind CSS</span>
            </div>
        </div>

        @if(env('APP_DEBUG'))
            <div style="margin-top: 1rem; padding: 0.8rem; background: #ffecb3; border-radius: 8px; font-size: 0.9rem;">
                ⚠️ Debug mode is enabled - {{ app()->environment() }} environment
            </div>
        @endif
    </div>
</body>
</html>