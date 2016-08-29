<div class="panel panel-primary">
	  <div class="panel-heading">
			<h3 class="panel-title">Kontak Online</h3>
	  </div>
	  <div class="panel-body">
			<form action="?page=simpankontak" method="POST">
				<table class="table">
					<tr>
						<td>Nama</td>
						<td><input type="text" name="nama" class="form-control" required></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="email" name="email" class="form-control" required></td>
					</tr>
					<tr>
						<td>Telpon</td>
						<td><input type="number" name="telpon" class="form-control"required></td>
					</tr>
					<tr>
						<td>Pesan</td>
						<td><textarea name="pesan" class="form-control" required></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Kirim" class="btn btn-success"></td>
					</tr>
				</table>
			</form>
	  </div>
</div>