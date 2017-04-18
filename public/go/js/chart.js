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
			data: [1,2,5,6,2,1,5],
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
            data: [1,2,5,6,2,1,5],
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
            data: [1,2,5,6,2,1,5],
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
            data: [1,2,5,6,2,1,5],
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
            data: [1,2,5,6,2,1,5],
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
            data: [1,2,5,6,2,1,5],
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







