<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Body Weight Calculator</title>
</head>
<body>
    <h1>Body Weight Calculator</h1>

    <form action="{{ route('bmi.calculate') }}" method="POST">
        @csrf
        <label>Weight (kg):</label>
        <input type="number" step="0.1" name="weight" required>
        <br>
        <label>Height (m):</label>
        <input type="number" step="0.01" name="height" required>
        <br>
        <button type="submit">Calculate BMI</button>
    </form>

    @if(isset($bmi))
        <h2>Your BMI: {{ $bmi }}</h2>
        <p>
            @if($bmi < 18.5)
                Underweight
            @elseif($bmi < 25)
                Normal weight
            @elseif($bmi < 30)
                Overweight
            @else
                Obese
            @endif
        </p>
    @endif
</body>
</html>