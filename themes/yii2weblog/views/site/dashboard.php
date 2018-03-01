<?php

use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $dataSetByHour array */
/* @var $dataSetByMonth array */
/* @var $dataSetByMonth array */
/* @var $dataSetByYear array */

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

$now = explode('-', date("Y-m-d-H-i-s"));
?>
<div class="site-index">
        <h4 style="text-align:center;">현재 시간은 <?=$now[0]?>년 <?=$now[1]?>월 <?=$now[2]?>일 <?=$now[3]?>시 <?=$now[4]?>분 <?=$now[5]?>초입니다.</h4>
        <ul class="chartjs-wrap">
                <li style="width:50%;">
                <?= ChartJs::widget([
                        'type' => 'line',
                        'options' => [
                                'height' => 2,
                                'width' => 4
                        ],
                        'data' => [
                                'labels' => $dataSetByHour['labels'],
                                'datasets' => [
                                        [
                                                'label' => Yii::t('app', "Hourly Visitors Statistics"),
                                                'backgroundColor' => "rgba(0,255,127,0.2)",
                                                'borderColor' => "rgba(0,255,127,1)",
                                                'pointBackgroundColor' => "rgba(0,255,127,1)",
                                                'pointBorderColor' => "#fff",
                                                'pointHoverBackgroundColor' => "#fff",
                                                'pointHoverBorderColor' => "rgba(0,255,127,1)",
                                                'data' => $dataSetByHour['data'],
                                        ],
                                ]
                        ]
                ]);
                ?>
                </li>
                <li style="width:50%;">
                <?= ChartJs::widget([
                        'type' => 'line',
                        'options' => [
                                'height' => 2,
                                'width' => 4
                        ],
                        'data' => [
                                'labels' => $dataSetByDay['labels'],
                                'datasets' => [
                                        [
                                                'label' => Yii::t('app', "Daily Visitors Statistics"),
                                                'backgroundColor' => "rgba(0,255,127,0.2)",
                                                'borderColor' => "rgba(0,255,127,1)",
                                                'pointBackgroundColor' => "rgba(0,255,127,1)",
                                                'pointBorderColor' => "#fff",
                                                'pointHoverBackgroundColor' => "#fff",
                                                'pointHoverBorderColor' => "rgba(0,255,127,1)",
                                                'data' => $dataSetByDay['data'],
                                        ],
                                ]
                        ]
                ]);
                ?>
                </li>
                <li style="width:50%;">
                <?= ChartJs::widget([
                        'type' => 'line',
                        'options' => [
                                'height' => 2,
                                'width' => 4
                        ],
                        'data' => [
                                'labels' => $dataSetByMonth['labels'],
                                'datasets' => [
                                        [
                                                'label' => Yii::t('app', "Monthly Visitors Statistics"),
                                                'backgroundColor' => "rgba(0,255,127,0.2)",
                                                'borderColor' => "rgba(0,255,127,1)",
                                                'pointBackgroundColor' => "rgba(0,255,127,1)",
                                                'pointBorderColor' => "#fff",
                                                'pointHoverBackgroundColor' => "#fff",
                                                'pointHoverBorderColor' => "rgba(0,255,127,1)",
                                                'data' => $dataSetByMonth['data'],
                                        ],
                                ]
                        ]
                ]);
                ?>
                </li>
                <li style="width:50%;">
                <?= ChartJs::widget([
                        'type' => 'line',
                        'options' => [
                                'height' => 2,
                                'width' => 4
                        ],
                        'data' => [
                                'labels' => $dataSetByYear['labels'],
                                'datasets' => [
                                        [
                                                'label' => Yii::t('app', "Yearly Visitors Statistics"),
                                                'backgroundColor' => "rgba(0,255,127,0.2)",
                                                'borderColor' => "rgba(0,255,127,1)",
                                                'pointBackgroundColor' => "rgba(0,255,127,1)",
                                                'pointBorderColor' => "#fff",
                                                'pointHoverBackgroundColor' => "#fff",
                                                'pointHoverBorderColor' => "rgba(0,255,127,1)",
                                                'data' => $dataSetByYear['data'],
                                        ],
                                ]
                        ]
                ]);
                ?>
                </li>
        </ul>
</div>
