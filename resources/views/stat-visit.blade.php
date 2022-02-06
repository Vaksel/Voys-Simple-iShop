<?php
$gridData = [
    'dataProvider' 			=> $dataProvider,
    'title' 				=> 'Статистика по городам',
    'useFilters' 			=> true,
    'defaultIdIsEnabled' 	=> false,
    'searchButtonLabel' => 'Поиск',
    'resetButtonLabel' 	=> 'Очистить',
    'columnFields' => [
        'id',
        [
            'attribute' => 'city_name',
            'label' 	=> 'Город'
        ],
        [
            'attribute' => 'user_qty',
            'label' 	=> 'К-во пользователей'
        ],
        [
            'attribute' => 'request_type',
            'label' 	=> 'Тип записи',
			'value' => function($val){
				if($val->request_type === 'visit')
				{
				    return 'Посещения сайта';
				}

    			if($val->request_type === 'appeal')
    			{
        			return 'Форма обратной связи';
    			}
			}
        ],
        [
            'attribute' => 'created_at',
            'label' 	=> 'Дата создания'
        ],
    ]
];
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container">
	<div class="date-select">
		Выберите интервал даты

		<input type="text" name="date-interval">
	</div>
	@gridView($gridData)
</div>

<script>
    function parseUri (str) {
        var	o   = parseUri.options,
            m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
            uri = {},
            i   = 14;

        while (i--) uri[o.key[i]] = m[i] || "";

        uri[o.q.name] = {};
        uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
            if ($1) uri[o.q.name][$1] = $2;
        });

        return uri;
    };

    parseUri.options = {
        strictMode: false,
        key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
        q:   {
            name:   "queryKey",
            parser: /(?:^|&)([^&=]*)=?([^&]*)/g
        },
        parser: {
            strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
            loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
        }
    };

    let query = parseUri(location.href);

    let queries = query['queryKey'];

    queries['filters%5Bdate_from%5D'] = moment(new Date()).format('YYYY-MM-DD');
    queries['filters%5Bdate_to%5D'] = moment(new Date()).format('YYYY-MM-DD');

    let queryPart = query['protocol'] + '://' + query['host'] + query['path'] + '?';

    for(i in queries)
	{
        queryPart = queryPart + i + '=' + queries[i] + '&';
	}

    queryPart = queryPart.substr(0,queryPart.length - 1);

    $(function() {
        $('input[name="date-interval"]').daterangepicker({
            "ranges": {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                'Последний месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " : ",
                "applyLabel": "Принять",
                "cancelLabel": "Отменить",
                "fromLabel": "От",
                "toLabel": "До",
                "customRangeLabel": "Свой промежуток",
                "weekLabel": "Н",
                "daysOfWeek": [
                    "Нд",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
            },
            "linkedCalendars": false,
        }, function(start, end, label) {

            let query = parseUri(location.href);

            let queries = query['queryKey'];

            queries['filters%5Bdate_from%5D'] = start.format('YYYY-MM-DD');
            queries['filters%5Bdate_to%5D'] = end.format('YYYY-MM-DD');

            let queryPart = query['protocol'] + '://' + query['host'] + query['path'] + '?';

            for(i in queries)
            {
                queryPart = queryPart + i + '=' + queries[i] + '&';
            }

            queryPart = queryPart.substr(0,queryPart.length - 1);

            location.href = queryPart;

            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");

		});
    });
</script>