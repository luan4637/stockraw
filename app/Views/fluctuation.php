<?php include('partials/header.php') ?>
<form id="filter">
	<select id="vol">
		<option value="10000"> > 10,000</option>
		<option value="50000"> > 50,000</option>
		<option value="70000"> > 70,000</option>
		<option value="100000"> > 100,000</option>
	</select>
	<select id="day">
		<?php for ($i = 0; $i <= 10; $i++): ?>
		<option <?php echo $i == 5 ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php endfor; ?>
	</select>
</form>
<div id="table"></div>
<div id="loading" class="loading">Loading</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/app.js"></script>
<script>
	$(document).ready(function() {
		loadTable();

        $('#day').on('change', function() {
            loadTable();
        });
	});

	function loadTable() {
		let filter = {
			vol: $('#vol').val(),
			day: $('#day').val(),
		};

		$.ajax({
			url: '/api/fluctuation',
			data: filter,
			dataType: 'json',
			beforeSend: () => {
				$('#loading').show();
			},
			success: (response) => {
				let stocks = response.data;
				$('#loading').hide();

				let $table = $('<table class="grid-table"></table>');
				let $row = $('<tr></tr>');
				$row.append('<th>code</th>');
				$row.append('<th>max</th>');
				$row.append('<th>min</th>');
                $row.append('<th>avg</th>');
				$row.append('<th>yesterday</th>');
				$row.append('<th>twoDayAgo</th>');
				$row.append('<th>threeDayAgo</th>');
				$row.append('<th>des</th>');
				$table.append($row);

				for (let i = 0; i < stocks.length; i++) {
					let item = stocks[i];
					let $row = $('<tr></tr>');
					$row.append('<td>'+ formatUrlTable(item.code) +'</td>');
					$row.append('<td>'+ formatDecimal(item.max) +'</td>');
					$row.append('<td>'+ formatDecimal(item.min) +'</td>');
					$row.append('<td>'+ formatDecimal(item.avg) +'</td>');
					$row.append('<td>'+ formatNumber(item.yesterday) +'</td>');
                    $row.append('<td>'+ formatNumber(item.twoDayAgo) +'</td>');
                    $row.append('<td>'+ formatNumber(item.threeDayAgo) +'</td>');
					$row.append('<td>'+ item.des +'</td>');
					$row.append('<td>'+ urlOrderStatistics(item.code) +'</td>');
					$table.append($row);
				}

				$('#table').html('').append($table);
			}
		});
	}
</script>
<?php include('partials/footer.php') ?>
