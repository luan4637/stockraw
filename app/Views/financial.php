<?php include('partials/header.php') ?>
<div id="table"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/plugins/jsgrid/jsgrid.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/apifinancial',
            dataType: 'json',
            success: function(response) {
                let codes = Object.keys(response);
                let results = [];
                for (let i = 0; i < codes.length; i++) {
                    let financial = response[codes[i]];
                    let quarters = Object.keys(financial);
                    for (let j = 0; j < quarters.length; j++) {
                        if (quarters[j].indexOf('2-2022') > -1) {
                            results.push(codes[i]);
                        }
                    }
                }
                for (let i = 0; i < results.length; i++) {
                    let code = results[i];
                    let $eleCode = $('<a target="_blank">').attr('href', `http://s.cafef.vn/hastc/${code}-${code}.chn`).text(code);
                    $('<li>').append($eleCode).appendTo($('#table'));
                }
            }
        });
    });
</script>
<?php include('partials/footer.php') ?>