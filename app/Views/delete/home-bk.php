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
	<input type="hidden" id="groupName" value="" />
</form>
<div>
	<ul id="groups"></ul>
</div>
<div id="table"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/plugins/jsgrid/jsgrid.min.js"></script>
<script>
	let intervalTable, intervalGroups;
	$(document).ready(function() {
		/*
		$('#table').jsGrid({
			width: '100%',
			height: '82vh',
			autoload: true,
			loadIndication: true,
			filtering: false,
			paging: true,
			pageSize: 99999,
			pageButtonCount: 5,
			pageIndex: 1,
			controller: {
				loadData: function(filter) {
					filter = {
						percent: $('#percent').val(),
						volPercent: $('#volPercent').val(),
						vol: $('#vol').val(),
						groupName: $('#groupName').val(),
					}
					return $.ajax({
						url: '/apiStock',
						data: filter,
						dataType: 'json'
					});
				}
			},
			fields: [
				{"name":"code","type":"text","width": "40px", "itemTemplate": function(value, item) {
					return '<a class="link-code" target="_blank" href="http://s.cafef.vn/hastc/' + value + '-' + value + '.chn">' + value + '</a>';
				}},
				<?php echo substr(json_encode($columnsDisplayed), 1, -1) ?>,
				{"name":"groupDes","type":"text","width": "40px", "itemTemplate": function(value, item) {
					return "<td class=\"group-des\"><i>Info</i><span>" + value + "</span></td>";
				}}
			]
		});
		*/
		$('#percent, #volPercent, #vol').on('change', function() {
			$('#table').jsGrid('loadData');
			clearInterval(intervalTable);
			clearInterval(intervalGroups);
			refreshTable();
			countGroups();
			refreshGroups();
		});
		$('#groups').on('click', 'li', function() {
			let groupName = $(this).find('strong').text();
			groupName = groupName == 'All' ? '' : groupName;
			$('#groupName').val(groupName);
			setTimeout(() => {
				$('#table').jsGrid('loadData');
				clearInterval(intervalTable);
				refreshTable();
			}, 200);
		});
		refreshTable();
	});

	function refreshTable() {
		/*
		let current = new Date();
		if (current.getHours() < 15 && current.getDay() != 0 && current.getDay() != 6) {
			intervalTable = setInterval(() => {
				$('#table').jsGrid('loadData');
			}, 30000);
		}*/


		let filter = {
			percent: $('#percent').val(),
			volPercent: $('#volPercent').val(),
			vol: $('#vol').val(),
			groupName: $('#groupName').val(),
		}

		return $.ajax({
			url: '/apiStock',
			data: filter,
			dataType: 'json',
			success: (response) => {
				let $table = $('<table class="grid-table"></table>');
				let $row = $('<tr></tr>');
				let urlCode = '<a class="link-code" target="_blank" href="http://s.cafef.vn/hastc/[CODE]-[CODE].chn">[CODE]</a>';
				$row.append('<th>code</th>');
				$row.append('<th>cur</th>');
				$row.append('<th>percent</th>');
				$row.append('<th>volPer</th>');
				$row.append('<th>vol</th>');
				$row.append('<th>volYes</th>');
				$row.append('<th>volYes</th>');
				$table.append($row);

				for (let i = 0; i < response.length; i++) {
					let item = response[i];
					let $row = $('<tr></tr>');
					$row.append('<td>'+ urlCode.replace(/\[CODE\]/g, item.code) +'</td>');
					$row.append('<td>'+ item.cur +'</td>');
					$row.append('<td>'+ item.percent +'</td>');
					$row.append('<td>'+ item.volPercent +'</td>');
					$row.append('<td>'+ item.vol +'</td>');
					$row.append('<td>'+ item.volYesterday +'</td>');
					$row.append('<td nowrap>'+ item.groupName +'</td>');
					$table.append($row);
				}

				$('#table').append($table);
			}
		});
	}

	function refreshGroups() {
		intervalGroups = setInterval(() => {
			countGroups();
		}, 60000);
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
				$('#groups').html('');
				$('#groups').append('<li><strong>All</strong></li>')
				for (let i = 0; i < names.length; i++) {
					$('#groups').append('<li><strong>' + names[i] + '</strong><span>' + response[names[i]] + '</span></li>')
				}
			}
		});
	}

	countGroups();
	refreshGroups();
</script>
<?php include('partials/footer.php') ?>
