<?php include('partials/header.php') ?>
<div id="table"></div>
<div id="loading" class="loading">Loading</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/app.js"></script>
<script>
	$(document).ready(function() {
		loadReportTable();
	});


	function loadReportTable() {
		$.ajax({
			url: '/api/filter/3up2down',
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
                $row.append('<th>exchange</th>');
                $row.append('<th>des</th>');
				$table.append($row);

				for (let i = 0; i < stocks.length; i++) {
					let item = stocks[i];
					let $row = $('<tr></tr>');
					$row.append('<td>'+ formatUrlTable(item.code) +'</td>');
                    $row.append('<td>'+ item.exchange +'</td>');
                    $row.append('<td>'+ item.des +'</td>');
					$table.append($row);
				}

				$('#table').html('').append($table);
			}
		});
	}

</script>
<?php include('partials/footer.php') ?>