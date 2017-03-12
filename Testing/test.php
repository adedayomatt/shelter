<html>

<head><title>Testing</title>
</head>
<body>
<form action="learn.php" method="post">
<label>Row1:<input name="one" type="text" value=<?php if(isset($_POST['one'])) echo($_POST['one'])?>></label>
<label>Row2:<input name="two" type="text" value=<?php if(isset($_POST['two'])) echo($_POST['two'])?>></label>
<label>Row3:<input name="three" type="text" value=<?php if(isset($_POST['three'])) echo($_POST['three'])?>></label>
<label>Row4:<input name="four" type="text" value=<?php if(isset($_POST['four'])) echo($_POST['four'])?>></label>
<input name="sub" type="submit" value="GO!" >
</form>
</body>
</html>