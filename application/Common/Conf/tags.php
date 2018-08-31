<?php
return array( // 添加下面一行定义即可
	'app_begin' => array(
        'Behavior\CronRunBehavior'     
    ),
    'app_init' => array(
        'Common\Behavior\InitHookBehavior',
    ),
    'view_filter' => array(
        'Common\Behavior\TmplStripSpaceBehavior'
    ),
    'admin_begin' => array(
        'Common\Behavior\AdminDefaultLangBehavior'
    )
)
;