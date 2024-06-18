<?php include('partials/header.php') ?>
<div class="top-head">
	<form id="filter">
		<select id="percent">
			<?php for ($i = 0; $i < 10; $i++): ?>
				<option value="<?php echo $i > 0 ? $i : '' ?>"
				<?php echo $i ==1 ? 'selected' : '' ?>
				> > <?php echo $i > 0 ? $i : 'ALL' ?></option>
			<?php endfor; ?>
		</select>
		<select id="volPercent">
			<option value="50"> > 50</option>
			<option value="70"> > 70</option>
			<option value="100"> > 100</option>
		</select>
		<select id="vol">
			<option value="50000"> > 50,000</option>
			<option value="70000"> > 70,000</option>
			<option value="100000"> > 100,000</option>
		</select>
		<select id="date">
			<?php foreach ($dates as $date): ?>
				<option value="<?php echo $date ?>"><?php echo $date ?></option>
			<?php endforeach; ?>
		</select>
		<select id="time">
			<?php foreach ($times as $time): ?>
				<option value="<?php echo $time ?>"><?php echo $time ?></option>
			<?php endforeach; ?>
		</select>
		<select id="prediction">
			<?php for ($i = 1; $i <= 5; $i++): ?>
				<option <?php echo $i == 5 ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php endfor; ?>
		</select>
		<span id="total-buy"></span> | <span id="total-sell"></span>
		<input type="hidden" id="groupId" value="0" />
	</form>
	<div class="groups-wrapper groups-hidden">
		<a class="btn-toggle js-btn-toggle">O</a>
		<ul id="groups"></ul>
	</div>
</div>
<div class="main-content">
	<div id="table"></div>
	<div id="footer"></div>
	<div id="loading" class="loading">Loading</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/app.js"></script>
<script>
	$(document).ready(function() {
		loadBuyTable();
		loadSellData();
		loadGroupList();

		$('.js-btn-toggle').on('click', function() {
			$(this).parent().toggleClass('groups-hidden');
		});
		$('#date').on('change', function() {
			loadSelect();
		});
		$('#percent, #volPercent, #vol, #time').on('change', function() {
			loadBuyTable();
			loadSellData();
			loadGroupList();
		});
	});

	function loadSelect() {
		let date = $('#date').val();
		$.ajax({
			url: '/api/stockdatas/datesAndTimesSelect',
			data: { date: date },
			dataType: 'json',
			success: (response) => {
				let times = response.data.times;
				let $selectTimes = $('#time');

				$selectTimes.html('<option>-----</option>');
				for (let i = 0; i < times.length; i++) {
					let $option = document.createElement('option');
					$option.value = $option.text = times[i];
					$selectTimes.append($option);
				}
			}
		});
	}

	function loadBuyTable() {
		let filter = {
			percent: $('#percent').val(),
			volPercent: $('#volPercent').val(),
			vol: $('#vol').val(),
			groupId: $('#groupId').val(),
			createdAt: $('#date').val(),
			createdTime: $('#time').val(),
			prediction: $('#prediction').val(),
		};

		$.ajax({
			url: '/api/stockdatas/history',
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
				$row.append('<th>ref</th>');
				$row.append('<th>cur</th>');
				$row.append('<th>percent</th>');
				$row.append('<th>volPer</th>');
				$row.append('<th>vol</th>');
				$row.append('<th>volYes</th>');
				$row.append('<th>Transactions</th>');
				$row.append('<th>Des</th>');
				$row.append('<th></th>');
				$table.append($row);

				for (let i = 0; i < stocks.length; i++) {
					let item = stocks[i];
					let percent = (item.cur - item.ref) / item.ref * 100;
					let volPercent = (item.vol / item.yesterday) * 100;
					let $transactions =  $('<ul></ul>');
					let $row = $('<tr></tr>');

					for (let j = 0; j < item.transactions.length; j++) {
						let itemTrans = item.transactions[j];
						let $trans = $('<li>' + itemTrans.date + ': ' + itemTrans.cur + '</li>');
						$transactions.append($trans);
					}

					$row.append('<td>'+ formatUrlTable(item.code) +'</td>');
					$row.append('<td>'+ item.ref +'</td>');
					$row.append('<td>'+ item.cur +'</td>');
					$row.append('<td>'+ formatDecimal(percent) +'</td>');
					$row.append('<td>'+ formatDecimal(volPercent) +'</td>');
					$row.append('<td>'+ formatNumber(item.vol) +'</td>');
					$row.append('<td>'+ formatNumber(item.yesterday) +'</td>');
					$row.append($('<td></td>').append($transactions));
					$row.append('<td class="des"><p class="text-ellipsis">' + item.des + '</p></td>');
					$row.append('<td><a href="/order?code=' + item.code + '" target="_blank">Orders</a></td>');
					
					if (parseFloat(item.cur) >= parseFloat(item.high)) {
						$row.addClass('row-purple')
					} else if (parseFloat(percent) > 0) {
						$row.addClass('row-green')
					}

					$table.append($row);
				}

				$('#table').html('').append($table);
				$('#total-buy').html(response.total);
			}
		});
	}

	function loadSellData() {
		let filter = {
			percent: -1,
			createdAt: $('#date').val(),
			createdTime: $('#time').val(),
			prediction: $('#prediction').val(),
		};

		$.ajax({
			url: '/api/stockdatas/sell',
			data: filter,
			dataType: 'json',
			success: (response) => {
				$('#total-sell').html(response.total);
			}
		});
	}

	function loadGroupList() {
		let filter = {
			percent: $('#percent').val(),
			volPercent: $('#volPercent').val(),
			vol: $('#vol').val(),
			createdAt: $('#date').val(),
			createdTime: $('#time').val(),
		};

		$.ajax({
			url: '/api/group/list',
			data: filter,
			dataType: 'json',
			success: (response) => {
				let groups = response.data;
				$('#groups').html('');
				for (let i = 0; i < groups.length; i++) {
					let item = groups[i];
					$('#groups').append('<li data-group-id="' + item.id + '"><strong>' + item.name + '</strong><span>' + item.totalStock + '</span></li>');
				}
				$('#groups').prepend('<li data-group-id="0"><strong>All</strong><span>' + response.total + '</span></li>');
			}
		});
	}
</script>
<?php include('partials/footer.php') ?>
