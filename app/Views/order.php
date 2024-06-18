<?php include('partials/header.php') ?>
<form id="filter" autocomplete="off">
	<input type="text" id="code" name="code" value="" />
	<input type="text" name="date" id="date_picker" />
	<button type="submit">Filter</button>
</form>
<div id="table"></div>
<div id="loading" class="loading">Loading</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/app.js"></script>
<script>
	var url = new URL(window.location.href);
	let code = url.searchParams.get('code');
	let date = url.searchParams.get('date');

	$(document).ready(function() {
		loadReportTable();
		datepicker('#date_picker', {
			formatter: (input, date, instance) => {
				input.value = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
  			}
		});
		$('#code').val(code);
		$('#date_picker').val(date);
	});


	function loadReportTable() {
        // var url = new URL(window.location.href);
        // let code = url.searchParams.get('code');
        // let date = url.searchParams.get('date');
		$.ajax({
			url: '/api/orders',
			dataType: 'json',
            data: { code: code, date: date },
			beforeSend: () => {
				$('#loading').show();
			},
			success: (response) => {
				let stocks = response.data;
				$('#loading').hide();

				let $table = $('<table class="grid-table"></table>');
				let $row = $('<tr></tr>');
				$row.append('<th>time</th>');
                $row.append('<th>price</th>');
                $row.append('<th>volOrder</th>');
                $row.append('<th>volCount</th>');
                $row.append('<th>proportion</th>');
				$table.append($row);

				for (let i = 0; i < stocks.length; i++) {
					let item = stocks[i];
					let $row = $('<tr></tr>');
					if (item.increase === true) {
						$row.addClass('increase');
					} else if (item.increase === false) {
						$row.addClass('decrease');
					}
					$row.append('<td>'+ item.time +'</td>');
                    $row.append('<td>'+ formatDecimal(item.price) +'</td>');
                    $row.append('<td>'+ formatNumber(item.volOrder) +'</td>');
                    $row.append('<td>'+ formatNumber(item.volCount) +'</td>');
                    $row.append('<td>'+ formatDecimal(item.proportion) +'</td>');
					$table.append($row);
				}

				$('#table').html('').append($table);
			}
		});
	}

</script>
<?php include('partials/footer.php') ?>