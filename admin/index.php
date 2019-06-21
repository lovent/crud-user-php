<?php 
include('../functions.php');
	if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}

	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM users WHERE id=$id");

		$n = mysqli_fetch_array($record);
		$name = $n['name'];
		$address = $n['address'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
	.header {
		background: #003366;
	}
	button[name=register_btn] {
		background: #003366;
	}
	</style>
</head>
<body>
	<div class="header">
		<h2>Admin - Home Page</h2>
	</div>
	<div class="content">
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<div class="profile_info">
			<img src="../images/admin_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>

		<div>
			<?php $results = mysqli_query($db, "SELECT * FROM users"); ?>

			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th>Username</th>
						<th>Address</th>
						<th>Email</th>
						<th colspan="2">Action</th>
					</tr>
				</thead>
				
				<?php while ($row = mysqli_fetch_array($results)) { ?>
					<tr>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['username']; ?></td>
						<td><?php echo $row['address']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td>
							<a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
						</td>
						<td>
							<a href="../functions.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
						</td>
					</tr>
				<?php } ?>
			</table>

			<form method="post" action="../functions.php" >
				<input type="hidden" name="id" value="<?php echo $id; ?>">

				<div class="input-group">
					<label>Name</label>
					<input type="text" name="name" value="<?php echo $name; ?>">
				</div>
				<div class="input-group">
					<label>Address</label>
					<input type="text" name="address" value="<?php echo $address; ?>">
				</div>
				<div class="input-group">
					<?php if ($update == true): ?>
						<button class="btn" type="submit" name="update" style="background: #556B2F;" >Update</button>
					<?php else: ?>
						<button class="btn" type="submit" name="save" >Add</button>
					<?php endif ?>
				</div>
			</form>
		</div>
	</div>		
</body>
</html>