@extends('layout.base')
@section('title')
    首页
@endsection

@section('main')
    <script src="{{elixir('go/js/highcharts.js')}}"></script>
    <script>
        $(function() {
            //新增商户数
            $('#allMerchant').highcharts({
                chart: {
                    style: {
                        fontSize: '8px',
                    },
                    type: 'area'
                },
                title: {
                    text:'总商户数量'
                },

                xAxis: {
                    type: 'datetime',
                    minRange: 7 * 24 * 3600000,
                    labels: {
                        formatter: function() {
                            return Highcharts.dateFormat('%m-%d', this.value);
                        }
                    },
                    tickPixelInterval: 50
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    allowDecimals: true,
                    labels: {
                        formatter: function() {
                            return this.value + '（人）';
                        }
                    },
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2016, 0, 26),
                    data: {{json_encode($shops)}},
                    showInLegend: false,
                }],

                colors: ['#ffb53e'],

                tooltip: {
                    borderWidth: 1,
                    dateTimeLabelFormats: {
                        day: '%Y-%m-%d'
                    },
                    formatter: function() {
                        return '总商户数量: <b>' + this.y + '人</b><br/>' + Highcharts.dateFormat('%Y-%m-%d', this.key) + '<br/><span class="chartPoint"></span>';
                    }
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: false // 禁用版权信息
                }
            });




            //当日新增商户数量
            $('#newMerchant').highcharts({
                chart: {
                    style: {
                        fontSize: '8px',
                    },
                    type: 'area'
                },
                title: {
                    text:'当日新增商户数量'
                },

                xAxis: {
                    type: 'datetime',
                    minRange: 7 * 24 * 3600000,
                    labels: {
                        formatter: function() {
                            return Highcharts.dateFormat('%m-%d', this.value);
                        }
                    },
                    tickPixelInterval: 50
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    allowDecimals: true,
                    labels: {
                        formatter: function() {
                            return this.value + '（人）';
                        }
                    },
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2016, 0, 26),
                    data: {{json_encode($shopd)}},
                    showInLegend: false,
                }],

                colors: ['#ffb53e'],

                tooltip: {
                    borderWidth: 1,
                    dateTimeLabelFormats: {
                        day: '%Y-%m-%d'
                    },
                    formatter: function() {
                        return '当日新增商户数量: <b>' + this.y + '人</b><br/>' + Highcharts.dateFormat('%Y-%m-%d', this.key) + '<br/><span class="chartPoint"></span>';
                    }
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: false // 禁用版权信息
                }
            });



            //总交易笔数
            $('#allTransaction').highcharts({
                chart: {
                    style: {
                        fontSize: '8px',
                    },
                    type: 'area'
                },
                title: {
                    text:'总交易笔数'
                },

                xAxis: {
                    type: 'datetime',
                    minRange: 7 * 24 * 3600000,
                    labels: {
                        formatter: function() {
                            return Highcharts.dateFormat('%m-%d', this.value);
                        }
                    },
                    tickPixelInterval: 50
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    allowDecimals: true,
                    labels: {
                        formatter: function() {
                            return this.value + '（笔）';
                        }
                    },
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2016, 0, 26),
                    data: {{json_encode($numbers)}},
                    showInLegend: false,
                }],

                colors: ['#1ebfae'],

                tooltip: {
                    borderWidth: 1,
                    dateTimeLabelFormats: {
                        day: '%Y-%m-%d'
                    },
                    formatter: function() {
                        return '总交易笔数: <b>' + this.y + '笔</b><br/>' + Highcharts.dateFormat('%Y-%m-%d', this.key) + '<br/><span class="chartPoint"></span>';
                    }
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: false // 禁用版权信息
                }
            });


            //当日交易笔数
            $('#newTransaction').highcharts({
                chart: {
                    style: {
                        fontSize: '8px',
                    },
                    type: 'area'
                },
                title: {
                    text:'当日交易笔数'
                },

                xAxis: {
                    type: 'datetime',
                    minRange: 7 * 24 * 3600000,
                    labels: {
                        formatter: function() {
                            return Highcharts.dateFormat('%m-%d', this.value);
                        }
                    },
                    tickPixelInterval: 50
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    allowDecimals: true,
                    labels: {
                        formatter: function() {
                            return this.value + '（笔）';
                        }
                    },
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2016, 0, 26),
                    data: {{json_encode($numberd)}},
                    showInLegend: false,
                }],

                colors: ['#1ebfae'],

                tooltip: {
                    borderWidth: 1,
                    dateTimeLabelFormats: {
                        day: '%Y-%m-%d'
                    },
                    formatter: function() {
                        return '当日交易笔数: <b>' + this.y + '笔</b><br/>' + Highcharts.dateFormat('%Y-%m-%d', this.key) + '<br/><span class="chartPoint"></span>';
                    }
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: false // 禁用版权信息
                }
            });


            //总交易金额
            $('#allPrice').highcharts({
                chart: {
                    style: {
                        fontSize: '8px',
                    },
                    type: 'area'
                },
                title: {
                    text:'总交易金额'
                },

                xAxis: {
                    type: 'datetime',
                    minRange: 7 * 24 * 3600000,
                    labels: {
                        formatter: function() {
                            return Highcharts.dateFormat('%m-%d', this.value);
                        }
                    },
                    tickPixelInterval: 50
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    allowDecimals: true,
                    labels: {
                        formatter: function() {
                            return this.value + '（元）';
                        }
                    },
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2016, 0, 26),
                    data: {{json_encode($amounts)}},
                    showInLegend: false,
                }],

                colors: ['#8ad919'],

                tooltip: {
                    borderWidth: 1,
                    dateTimeLabelFormats: {
                        day: '%Y-%m-%d'
                    },
                    formatter: function() {
                        return '总交易金额: <b>' + this.y + '元</b><br/>' + Highcharts.dateFormat('%Y-%m-%d', this.key) + '<br/><span class="chartPoint"></span>';
                    }
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: false // 禁用版权信息
                }
            });



            //当日交易金额
            $('#newPrice').highcharts({
                chart: {
                    style: {
                        fontSize: '8px',
                    },
                    type: 'area'
                },
                title: {
                    text:'当日交易金额'
                },

                xAxis: {
                    type: 'datetime',
                    minRange: 7 * 24 * 3600000,
                    labels: {
                        formatter: function() {
                            return Highcharts.dateFormat('%m-%d', this.value);
                        }
                    },
                    tickPixelInterval: 50
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    allowDecimals: true,
                    labels: {
                        formatter: function() {
                            return this.value + '（元）';
                        }
                    },
                },
                series: [{
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2016, 0, 26),
                    data: {{json_encode($amountd)}},
                    showInLegend: false,
                }],

                colors: ['#8ad919'],

                tooltip: {
                    borderWidth: 1,
                    dateTimeLabelFormats: {
                        day: '%Y-%m-%d'
                    },
                    formatter: function() {
                        return '当日交易金额: <b>' + this.y + '元</b><br/>' + Highcharts.dateFormat('%Y-%m-%d', this.key) + '<br/><span class="chartPoint"></span>';
                    }
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                credits: {
                    enabled: false // 禁用版权信息
                }
            });
        });
    </script>
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a></span>
        </div>
        <div class="indShow">
            <ul>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 blue else">&#xe629;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['profit']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">总分润金额</span>
                    </div>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 yellow else">&#xe921;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['shop']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">总商户数量</span>
                    </div>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 green">&#xe63f;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['number']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">总交易笔数</span>
                    </div>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 red else">&#xe665;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['amount']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">总交易金额</span>
                    </div>
                </li>

                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 blue else">&#xe629;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['profitt']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">当日分润金额</span>
                    </div>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 yellow else">&#xe921;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['shopt']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">当日新增商户数量</span>
                    </div>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 green">&#xe63f;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['numbert']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">当日交易笔数</span>
                    </div>
                </li>
                <li class="col-xs-6 col-md-6 col-lg-3">
                    <div class="contentBox">
                        <span class="iconFont col-xs-3 col-sm-3 col-lg-4 red else">&#xe665;</span>
                        <span class="num col-xs-9 col-sm-9 col-lg-8">{{$head['amountt']}}</span>
                        <span class="name col-xs-9 col-sm-9 col-lg-8">当日交易金额</span>
                    </div>
                </li>
            </ul>
        </div>

        <div class="chartBox">
            <div class="line">
                <div id="allMerchant" style="min-width: 200px; height: 300px;"></div>
            </div>
            <div class="line">
                <div id="newMerchant" style="min-width: 200px; height: 300px;"></div>
            </div>

            <div class="line">
                <div id="allTransaction" style="min-width: 200px; height: 300px;"></div>
            </div>
            <div class="line">
                <div id="newTransaction" style="min-width: 200px; height: 300px;"></div>
            </div>

            <div class="line">
                <div id="allPrice" style="min-width: 200px; height: 300px;"></div>
            </div>
            <div class="line">
                <div id="newPrice" style="min-width: 200px; height: 300px;"></div>
            </div>
        </div>

        <div class="content">

        </div>
    </div>
@endsection