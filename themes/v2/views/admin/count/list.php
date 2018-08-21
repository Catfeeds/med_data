<?php
$this->pageTitle = '数据统计';
$this->breadcrumbs = array($this->pageTitle);
?>
<!-- <script src="/static/global/scripts/echarts/echarts.js"></script> -->

<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline">
            <div class="form-group">
                <?php echo CHtml::dropDownList('ks',$ks,CHtml::listData(TagExt::model()->normal()->findAll('cate="ks"'),'id','name'),array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--选择科室--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('area',$area,CHtml::listData(TagExt::model()->normal()->findAll('cate="area"'),'id','name'),array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--选择地区--')); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::dropDownList('dis',$dis,$diss,array('class'=>'form-control chose_select','encode'=>false,'prompt'=>'--选择疾病--')); ?>
            </div>
            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
        </form>
    </div>
</div>
<div class="note note-info">
    <!-- <h4 class="block">Info! Some Header Goes Here</h4> -->
    <center>    <p>
         满足以上条件各单位已完成的例数为：<strong><?=$allnum?></strong> 例。
    </p></center>
</div>
<div class="row">
    <div class="col-md-12">
    <?php if(!$ks): ?>
        <div class="col-md-6">
            <div style="height: 400px" id="main1"></div>
        </div>
    <?php endif;?>
    <?php if(!$area): ?>
        <div class="col-md-6">
            <div style="height: 400px" id="main2"></div>
        </div>
    <?php endif;?>
    <?php if(!$dis): ?>
        <div class="col-md-6">
            <div style="height: 400px" id="main3"></div>
        </div>
    <?php endif;?>
    </div>
</div>

<script>
<?php Tools::startJs(); ?>
<?php if(!$ks): ?>
// 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main1'));
    option = {
    title: {
        text: '科室-完成例数分布图',
        // subtext: 'Feature Sample: Gradient Color, Shadow, Click Zoom'
    },
    toolbox: {
        feature: {
            dataView: {show: true, readOnly: false},
            magicType: {show: true, type: ['line', 'bar', 'pie']},
            restore: {show: true},
            saveAsImage: {show: true}
        }
    },
    xAxis: {
        data: <?php echo CJSON::encode($ksarr['key']); ?>,
        axisLabel: {
            // inside: true,
            show: true,
            textStyle: {
                color: '#000'
            },
            
        },
        axisTick: {
            show: false
        },
        axisLine: {
            show: false
        },
        z: 10
    },
    yAxis: {
        axisLine: {
            show: false
        },
        axisTick: {
            show: false
        },
        axisLabel: {
            textStyle: {
                color: '#999'
            }
        }
    },
    dataZoom: [
        {
            type: 'inside'
        }
    ],
    series: [
        {
            name: '完成例数',
            barWidth: 80,
            type: 'bar',
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#83bff6'},
                            {offset: 0.5, color: '#188df0'},
                            {offset: 1, color: '#188df0'}
                        ]
                    )
                },
                emphasis: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#2378f7'},
                            {offset: 0.7, color: '#2378f7'},
                            {offset: 1, color: '#83bff6'}
                        ]
                    )
                }
            },
            label: {
                normal: {
                    show: true
                },
                position: 'inside'
            },
            data: <?php echo CJSON::encode($ksarr['value']); ?>
        }
    ]
};
myChart.setOption(option);
// Enable data zoom when user click bar.
var zoomSize = 6;
myChart.on('click', function (params) {
    console.log(dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)]);
    myChart.dispatchAction({
        type: 'dataZoom',
        startValue: dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)],
        endValue: dataAxis[Math.min(params.dataIndex + zoomSize / 2, data.length - 1)]
    });
});
<?php endif;?>
<?php if(!$area): ?>
    var myChart = echarts.init(document.getElementById('main2'));
    option = {
    title: {
        text: '地区-完成例数分布图',
        // subtext: 'Feature Sample: Gradient Color, Shadow, Click Zoom'
    },
    toolbox: {
        feature: {
            dataView: {show: true, readOnly: false},
            magicType: {show: true, type: ['line', 'bar', 'pie']},
            restore: {show: true},
            saveAsImage: {show: true}
        }
    },
    xAxis: {
        data: <?php echo CJSON::encode($areaarr['key']); ?>,
        axisLabel: {
            // inside: true,
            show: true,
            textStyle: {
                color: '#000'
            },
            
        },
        axisTick: {
            show: false
        },
        axisLine: {
            show: false
        },
        z: 10
    },
    yAxis: {
        axisLine: {
            show: false
        },
        axisTick: {
            show: false
        },
        axisLabel: {
            textStyle: {
                color: '#999'
            }
        }
    },
    dataZoom: [
        {
            type: 'inside'
        }
    ],
    series: [
        {
            name: '完成例数',
            barWidth: 80,
            type: 'bar',
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#83bff6'},
                            {offset: 0.5, color: '#188df0'},
                            {offset: 1, color: '#188df0'}
                        ]
                    )
                },
                emphasis: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#2378f7'},
                            {offset: 0.7, color: '#2378f7'},
                            {offset: 1, color: '#83bff6'}
                        ]
                    )
                }
            },
            label: {
                normal: {
                    show: true
                },
                position: 'inside'
            },
            data: <?php echo CJSON::encode($areaarr['value']); ?>
        }
    ]
};
myChart.setOption(option);
// Enable data zoom when user click bar.
var zoomSize = 6;
myChart.on('click', function (params) {
    console.log(dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)]);
    myChart.dispatchAction({
        type: 'dataZoom',
        startValue: dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)],
        endValue: dataAxis[Math.min(params.dataIndex + zoomSize / 2, data.length - 1)]
    });
});
<?php endif;?>
<?php if(!$dis): ?>
    var myChart = echarts.init(document.getElementById('main3'));
    option = {
    title: {
        text: '疾病-完成例数分布图',
        // subtext: 'Feature Sample: Gradient Color, Shadow, Click Zoom'
    },
    toolbox: {
        feature: {
            dataView: {show: true, readOnly: false},
            magicType: {show: true, type: ['line', 'bar', 'pie']},
            restore: {show: true},
            saveAsImage: {show: true}
        }
    },
    xAxis: {
        data: <?php echo CJSON::encode($disarr['key']); ?>,
        axisLabel: {
            // inside: true,
            show: true,
            textStyle: {
                color: '#000'
            },
            
        },
        axisTick: {
            show: false
        },
        axisLine: {
            show: false
        },
        z: 10
    },
    yAxis: {
        axisLine: {
            show: false
        },
        axisTick: {
            show: false
        },
        axisLabel: {
            textStyle: {
                color: '#999'
            }
        }
    },
    dataZoom: [
        {
            type: 'inside'
        }
    ],
    series: [
        {
            name: '完成例数',
            barWidth: 80,
            type: 'bar',
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#83bff6'},
                            {offset: 0.5, color: '#188df0'},
                            {offset: 1, color: '#188df0'}
                        ]
                    )
                },
                emphasis: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#2378f7'},
                            {offset: 0.7, color: '#2378f7'},
                            {offset: 1, color: '#83bff6'}
                        ]
                    )
                }
            },
            label: {
                normal: {
                    show: true
                },
                position: 'inside'
            },
            data: <?php echo CJSON::encode($disarr['value']); ?>
        }
    ]
};
myChart.setOption(option);
// Enable data zoom when user click bar.
var zoomSize = 6;
myChart.on('click', function (params) {
    console.log(dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)]);
    myChart.dispatchAction({
        type: 'dataZoom',
        startValue: dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)],
        endValue: dataAxis[Math.min(params.dataIndex + zoomSize / 2, data.length - 1)]
    });
});
<?php endif;?>
    setInterval(function(){
        $('#AdminIframe').height($('#AdminIframe').contents().find('body').height());
        var $panel_title = $('#fade-title');
        $panel_title.html($('#AdminIframe').contents().find('title').html());
    },200);
    function do_admin(ts){
        $('#AdminIframe').attr('src',ts.data('url')).load(function(){
            self = this;
            //延时100毫秒设定高度
            $('#Admin').modal({ show: true, keyboard:false });
            $('#Admin .modal-dialog').css({width:'1000px'});
        });
    }
    function set_sort(_this, id, sort){
            $.getJSON('<?php echo $this->createUrl('/admin/league/setSort')?>',{id:id,sort:sort,class:'<?=isset($infos[0])?get_class($infos[0]):''?>'},function(dt){
                location.reload();
            });
        }
    function do_sort(ts){
        if(ts.which == 13){
            _this = $(ts.target);
            sort = _this.val();
            id = _this.parent().data('id');
            set_sort(_this, id, sort);
        }
    }

    $(document).on('click',function(e){
          var target = $(e.target);
          if(!target.hasClass('sort_edit')){
             $('.sort_edit').trigger($.Event( 'keypress', 13 ));
          }
    });
    $('.sort_edit').click(function(){
        if($(this).find('input').length <1){
            $(this).html('<input type=\"text\" value=\"' + $(this).html() + '\" class=\"form-control input-sm sort_edit\" onkeypress=\"return do_sort(event)\" onblur=\"set_sort($(this),$(this).parent().data(\'id\'),$(this).val())\">');
            $(this).find('input').select();
        }
    });
    var getChecked  = function(){
        var ids = "";
        $(".checkboxes").each(function(){
            if($(this).parents('span').hasClass("checked")){
                if(ids == ''){
                    ids = $(this).val();
                } else {
                    ids = ids + ',' + $(this).val();
                }
            }
        });
        return ids;
    }

    $(".group-checkable").click(function () {
        var set = $(this).attr("data-set");
        $(set).each(function () {
            $(this).attr("checked", !$(this).attr("checked"));
        });
        $.uniform.update(set);
    });
    //清空选项
    function removeOptions()
    {
        // alert($('.chose_select').val());
        $('.chose_text').val('');
        $('.chose_select').val('');
    }

    $("#hname").on("dblclick",function(){
        var hnames = $(".hname");
        console.log(hnames);
        hnames.each(function(){
            var _this = $(this);
            $.getJSON("<?php echo $this->createUrl('/api/houses/getsearch') ?>",{key:_this.html()},function(dt){
                _this.append(" (" + dt.msg[1].length + ")");
            });
        });
    });
    <?php Yii::app()->clientScript->registerScriptFile("/static/global/scripts/echarts/echarts.js",CClientScript::POS_END); ?>

<?php Tools::endJs('js') ?>
</script>