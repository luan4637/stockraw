<?php include('partials/header.php') ?>
<div class="buttons">
	<button class="active" data-url="/apireport/report3up1down">3up1down</button>
	<button data-url="/apireport/report3up2down">3up2down</button>
	<button data-url="/apireport/report3up">3up</button>
</div>
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
			paging: true,
			pageSize: 99999,
			pageButtonCount: 5,
			pageIndex: 1,
			controller: {
				loadData: function(filter) {
					return $.ajax({
						url: '/apireport/report3up1down',
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
		$('.buttons > button').on('click', function() {
			let requestUrl = '/apireport/report3up1down';
			let url = $(this).attr('data-url');
			if (typeof url != 'undefined') {
				requestUrl = url;
			}
			$('#table').jsGrid({
				controller: {
					loadData: function(filter) {
						return $.ajax({
							url: requestUrl,
							data: filter,
							dataType: 'json'
						});
					}
				}
			});

			$(this).parent().find('button').removeClass('active');
			$(this).addClass('active');
		});
	});
</script>
<?php include('partials/footer.php') ?>
