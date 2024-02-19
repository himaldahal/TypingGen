<?php
include('includes/config.php');
if(!isset($_SESSION['user_id'])){
    header('Location: /auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypingGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .typing-text {
            font-size: 18px;
            text-align: justify;
            line-height: 1.5;
        }

         
        .result-details li {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .btn-try-again {
            font-size: 16px;
        }
        .input-field {
            font-size: 16px;
            margin-top: 20px;
            outline: 0;
            border-width: 0 0 2px;
            border-color: blue
            }
            .input-field:focus {
            border-color: green;
            outline: 1px dotted #000
}
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/js/paragraph.js"></script>


</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container">
<h2 class="text-center">TypingGen</h2>
<hr>
    <div class="row justify-content-center">
        <div class="col-4">
        <div class="text-center mb-4">
                <div class="btn-group">
                    <button type="button" class="btn time-selected btn-secondary" >30</button>
                    <button type="button" class="btn time-selected btn-warning clicked">60</button>
                </div>
            </div>
            <div class="result-details">
                        <ul class="list-unstyled">
                            <h2>STATS</h2>
                            <hr>
                            <li class="mb-2"><strong>Time Left:</strong> <span id="timeLeft">60</span>s</li>
                            <li class="mb-2"><strong>Mistakes:</strong> <span id="mistakes">0</span></li>
                            <li class="mb-2"><strong>WPM:</strong> <span id="wpm">0</span></li>
                            <li class="mb-2"><strong>CPM:</strong> <span id="cpm">0</span></li>
                        </ul>
                    </div>
        </div>

        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="typing-text mb-3">
                        <p></p>
                    </div>
            <input type="text" class="form-control input-field" id="typing" placeholder="Type here">
                    <button type="button" class="btn btn-primary btn-try-again mt-3" style="display: none;">Retry</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/script.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

</body>
</html>
