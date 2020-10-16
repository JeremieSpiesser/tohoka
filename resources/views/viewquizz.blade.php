</<!DOCTYPE html>
<html>
<head>
   
</head>
<body>

<?php
$quizzs = \App\Models\Quizz::all();
?>

<h1>All the quizzs :</h1>
<ul>
@foreach ($quizzs as $quizz)

<li><b> {{ $quizz->name }} </b> : {{ $quizz->content }} </li>

@endforeach
</ul>

</body>
</html>
