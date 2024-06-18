<?php include('partials/header.php') ?>
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
	<span id="total-buy"></span> | <span id="total-sell"></span>
	<input type="hidden" id="groupName" value="" />
</form>
<div class="groups-wrapper groups-hidden">
	<a class="btn-toggle js-btn-toggle">O</a>
	<ul id="groups"></ul>
</div>
<div id="table"></div>
<div id="footer"></div>
<div id="loading" class="loading">Loading</div>
<div id="warning" class="warning" style="display: none">warning</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/plugins/jsgrid/jsgrid.min.js"></script>
<script>
	let intervalTable, intervalGroups;
	$(document).ready(function() {
		$('.js-btn-toggle').on('click', function() {
			$(this).parent().toggleClass('groups-hidden');
		});
		$('#percent, #volPercent, #vol').on('change', function() {
			clearInterval(intervalTable);
			clearInterval(intervalGroups);
			loadTable();
			refreshTable();
			countGroups();
			refreshGroups();
		});
		$('#groups').on('click', 'li', function() {
			let groupName = $(this).find('strong').text();
			groupName = groupName == 'All' ? '' : groupName;
			$('#groupName').val(groupName);
			setTimeout(() => {
				clearInterval(intervalTable);
				loadTable();
				refreshTable();
			}, 200);
		});
		loadTable();
		refreshTable();
	});

	function refreshTable() {
		intervalTable = setInterval(() => {
			loadTable();
			checkRawing();
		}, 10000);
	}

	function checkRawing() {
		$.ajax({
			url: '/apiStock/rawing',
			dataType: 'json',
			success: (response) => {
				if (response.status) {
					$('#warning').hide();
				} else {
					$('#warning').show();
				}
			}
		});
	}

	function loadTable() {
		let filter = {
			percent: $('#percent').val(),
			volPercent: $('#volPercent').val(),
			vol: $('#vol').val(),
			groupName: $('#groupName').val(),
		}

		$.ajax({
			url: '/apiStock',
			data: filter,
			dataType: 'json',
			beforeSend: () => {
				$('#loading').show();
			},
			success: (response) => {
				let stocks = response.stocks;
				$('#loading').hide();

				let $table = $('<table class="grid-table"></table>');
				let $row = $('<tr></tr>');
				let urlCode = '<a class="link-code" target="_blank" href="http://s.cafef.vn/hastc/[CODE]-[CODE].chn">[CODE]</a>';
				$row.append('<th>code</th>');
				$row.append('<th>cur</th>');
				$row.append('<th>percent</th>');
				$row.append('<th>volPer</th>');
				$row.append('<th>vol</th>');
				$row.append('<th>volYes</th>');
				$row.append('<th>Des</th>');
				$table.append($row);

				for (let i = 0; i < stocks.length; i++) {
					let item = stocks[i];
					let $row = $('<tr></tr>');
					$row.append('<td>'+ urlCode.replace(/\[CODE\]/g, item.code) +'</td>');
					$row.append('<td>'+ item.cur +'</td>');
					$row.append('<td>'+ item.percent +'</td>');
					$row.append('<td>'+ item.volPercent +'</td>');
					$row.append('<td>'+ item.vol +'</td>');
					$row.append('<td>'+ item.volYesterday +'</td>');
					$row.append('<td nowrap>' + item.groupName + '</td>');
					
					if (parseFloat(item.cur) >= parseFloat(item.top)) {
						$row.addClass('row-purple')
					} else if (parseFloat(item.percent) > 0) {
						$row.addClass('row-green')
					}

					$table.append($row);
				}

				$('#table').html('').append($table);
				$('#total-buy').html(response.totalBuy);
				$('#total-sell').html(response.totalSell);
			}
		});
	}

	function refreshGroups() {
		intervalGroups = setInterval(() => {
			countGroups();
		}, 10000);
	}

	function countGroups() {
		filter = {
			percent: $('#percent').val(),
			volPercent: $('#volPercent').val(),
			vol: $('#vol').val(),
		};
		$.ajax({
			url: '/apiStock/countGroup',
			data: filter,
			dataType: 'json',
			success: (response) => {
				let names = Object.keys(response);
				let total = 0;
				$('#groups').html('');
				for (let i = 0; i < names.length; i++) {
					$('#groups').append('<li><strong>' + names[i] + '</strong><span>' + response[names[i]] + '</span></li>');
					total += parseInt(response[names[i]]);
				}
				$('#groups').prepend('<li><strong>All</strong><span>' + total + '</span></li>');
			}
		});
	}

	countGroups();
	refreshGroups();
</script>
<?php include('partials/footer.php') ?>
