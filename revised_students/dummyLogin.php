<!doctype html>
<html lang="en">
  <head>
    <meta crset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Control Panel</title>

    <!-- Bootstrap core CSS -->
    <link href="../components/bootstrap.min.css" rel="stylesheet">
  </head>
<body>

<!-- <a class="nav-link" href="studentPage.php?user_id=1022788">
Enter page
</a> -->

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown button
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
    <label class="form-check-label" for="defaultCheck1">
      Moyes
    </label>
    <br>
    <input class="form-check-input" type="checkbox" value="M" id="moyes">
    <label class="form-check-label" for="defaultCheck2">
      Default checkbox
    </label>
    <br>
    <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
    <label class="form-check-label" for="defaultCheck3">
      Default checkbox
    </label>
  </div>
</div>

<select class="form-select multiple" aria-label="Default select example">
  <option selected>Open this select menu</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>

<select class="form-select" multiple>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>

<div id="list1" class="dropdown-check-list" tabindex="100">
  <span class="anchor">Select Fruits</span>
  <ul class="items">
    <li><input type="checkbox" />Apple </li>
    <li><input type="checkbox" />Orange</li>
    <li><input type="checkbox" />Grapes </li>
    <li><input type="checkbox" />Berry </li>
    <li><input type="checkbox" />Mango </li>
    <li><input type="checkbox" />Banana </li>
    <li><input type="checkbox" />Tomato</li>
  </ul>
</div>

<ul class="dropdown-menu checkbox-menu">
  <h1>Test</h1>
  <li >
    <label>
      <input type="checkbox">Cheese</input>
    </label>
  </li>
</ul>

<div class="form-group">
  <label for="staff">Staff Selected</label>
  <div class="dropdown" id='staff'>
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown</button>
    <div class="dropdown-menu">
      <button class="dropdown-item" type="button">
        <input type="checkbox">Action
      </button>
      <button class="dropdown-item" type="button">
        <input type="checkbox">Action
      </button>
      <button class="dropdown-item" type="button">
        <input type="checkbox">Action
      </button>
    </div>
  </div>
<br>

<div class="container">
	<h2>Example: Multi Select Dropdown with Checkbox using Bootstrap</h2>    
	<form method="get" action="multiselect_action.php">
		<h4>What's your favorite football teams?</h4>		
		<div class="form-group">
			<select id="countries" name="countries[]" multiple >						    
				<option value="Brazil">Brazil</option>
				<option value=" Argentina"> Argentina</option>		
				<option value="Germany">Germany</option>
				<option value=" Chile"> Chile</option>
				<option value="Colombia">Colombia</option>
				<option value=" France"> France</option>
				<option value=" Belgium"> Belgium</option>
				<option value="Spain">Spain</option>
			</select>	
		</div>	
		<div class="form-group">
			<br>	
			<button type="submit" class="btn btn-default" name="btn-save" id="btn-submit">
				 Submit
			</button> 
		</div>     
	</form>	
</div>

<div class="container mt-5">
  <select class="selectpicker" multiple aria-label="size 3 select example">
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
    <option value="4">Four</option>
  </select>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="../components/mdb.min.js"></script>
<script>$('select').selectpicker();</script>
</body>
