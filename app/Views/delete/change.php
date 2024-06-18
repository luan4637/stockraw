<?php include('partials/header.php') ?>
<form id="filter">
	<select id="vol">
		<option value="0"> > 0</option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/plugins/jsgrid/jsgrid.min.js"></script>
<script>
	$(document).ready(function() {
		$('#table').jsGrid({
			width: '100%',
			height: '96vh',
			autoload: true,
			loadIndication: true,
			filtering: false,
			sorting: false,
			paging: true,
			pageSize: 99999,
			pageButtonCount: 5,
			pageIndex: 1,
			controller: {
				loadData: function(filter) {
					filter = {
						volYesterday: $('#vol').val(),
						day: $('#day').val(),
						sort: 'avg',
						order: 'asc',
					}
					return $.ajax({
						url: '/apichange/change5days',
						data: filter,
						dataType: 'json'
					});
				}
			},
			fields: [
				{"name":"code","type":"text","width": "60px", "itemTemplate": function(value, item) {
					return '<a class="link-code" target="_blank" href="http://s.cafef.vn/hastc/' + value + '-' + value + '.chn">' + value + '</a>';
				}},
				<?php echo substr(json_encode($columnsDisplayed), 1, -1) ?>,
				{"name":"groupDes","type":"text","width": "40px", "itemTemplate": function(value, item) {
					return "<div class=\"group-des\"><i>Info</i><span>" + value + "</span></div>";
				}}
			]
		});
		$('#vol, #day').on('change', function() {
			$('#table').jsGrid('loadData');
		});
	});
</script>
<?php include('partials/footer.php') ?>
