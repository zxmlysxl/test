<?php
function zuoxm_ads() {    
    wp_enqueue_script('jquery');    
    wp_enqueue_style('slick-style', get_template_directory_uri().'/zuoxm/css/slick.css');    
    wp_enqueue_script('slick-script', get_template_directory_uri().'/zuoxm/js/slick.min.js'); 
    if (_pz('ZUOXM_ADS_OPEN')){
        $bfields=_pz('ZUOXM_BIMGADS');//大横幅广告数组
        $sfields=_pz('ZUOXM_SIMGADS');//小横幅广告数组
        $tfields=_pz('ZUOXM_TXTADS');//纯文本广告数组
        $vipads =_pz('ZUOXM_PAYVIP');//PAYVIP广告
        $speed  =intval(_pz('ZUOXM_ADS_SPEED'))*1000;//广告轮播时间间隔
        // 设置时区为+8时区  
        date_default_timezone_set('Asia/Shanghai');
        $current_time = strtotime(date("Y-m-d H:i:s"));  // 获取当前时间并转换为Unix时间戳
        $zxm_ads = '<div class="container fluid-widget"><div class="widget_text zib-widget widget_custom_html"><div class="textwidget custom-html-widget">';
         //PAYVIP广告插入
        $zxm_ads .='<div class="pay-vip"><a href="javascript:;"><img src="' .$vipads.'"></a></div>'; 
        //大横幅广告区块
        if (!empty($bfields)) { 
            $zxm_ads .='<div class="ad">';
            foreach ($bfields as $bad) {      
                $bimagePath = $bad['zbasimg'];       
                $burl = $bad['zbasurl'];    
                $bstartTime = strtotime($bad['zbastart']);        
                $bendTime = strtotime($bad['zbasend']);
                if ($current_time >= $bstartTime && $current_time <= $bendTime) {
                    $zxm_ads .= '<div><a href="' . esc_url($burl) . '" target="_blank" rel="nofollow"><img src="' . esc_url($bimagePath) . '"></a></div>'; 
                }
            }     
            $zxm_ads .='</div><script>  
                        <!--大横幅广告滑块，淡入淡出效果-->
                    jQuery(document).ready(function($) {    
                        var slider = $(".ad");    
                        slider.slick({    
                            dots: false,    
                            arrows: false,    
                            infinite: true,    
                            speed: 1000, //完成图片切换的时长   
                            fade: true,    
                            cssEase: "linear",    
                            slidesToShow: 1,    
                            slidesToScroll: 1,  
                            autoplay: true,  // 启用自动播放  
                            autoplaySpeed: '.$speed.' 
                        });
                    });   
                    /*<!--大横幅广告滑块，滑动效果-->
                    jQuery(document).ready(function($) {  
                            var slider = $(".ad");  
                            slider.slick({  
                                dots: false,  
                                arrows: false,  
                                infinite: true,  
                                speed: 500,  
                                slidesToShow: 1,  
                                slidesToScroll: 1
                            });  
                            setInterval(function() {  
                                slider.slick("slickNext");  
                            }, '.$speed.'); //定时滑动
                        });*/
                    </script>';
        }    
        //小横幅广告区块
        if (!empty($sfields)){
            //小横幅广告加载
            $zxm_ads .='<div class="adb">';
            foreach ($sfields as $sad) {  
                $simagePath = $sad['zbasimg'];  // 图片路径  
                $surl = $sad['zbasurl'];  // 链接  
                $sstartTime = strtotime($sad['zbastart']);  // 提取开始时间并转换为unix时间戳  
                $sendTime = strtotime($sad['zbasend']);  // 提取结束时间并转换为unix时间戳 
                if ($current_time >= $sstartTime && $current_time <= $sendTime) {  
                    $zxm_ads .= '<li><a href="' . esc_url($surl) . '" target="_blank" rel="nofollow"><img src="' . esc_url($simagePath) . '"></a></li>';  
                }  
            }
            $zxm_ads .= '</div><script><!--小横幅广告滑块-->
                        jQuery(document).ready(function($) {  
                        var sliderS = $(".adb");  
                        sliderS.slick({  
                            dots: false,  
                            arrows: false,  
                            infinite: true,  
                            speed: 500,  
                            slidesToShow: 2,  
                            slidesToScroll: 1,  
                            vertical: false,
                            cssTransforms3d: true, // 启用3D变换效果  
                        });  
                        setInterval(function() {  
                            sliderS.slick("slickNext");  
                        }, '.$speed.'); 
                    });  </script>';
        }
        if (!empty($tfields)){
            $tfieldsCount = count($tfields);
            $slidesToShow = ($tfieldsCount <= 4) ? $tfieldsCount : 4;
            //纯文本广告加载
            $zxm_ads .= '<div class="txtguanggao">';
            foreach ($tfields as $tad) {  
                $ttxt = $tad['zbastxt'];  // 文本内容  
                $turl = $tad['zbasurl'];  // 广告链接  
                $tstartTime = strtotime($tad['zbastart']);  // 提取开始时间并转换为unix时间戳  
                $tendTime = strtotime($tad['zbasend']);  // 提取结束时间并转换为unix时间戳 
                
                if ($current_time >= $tstartTime && $current_time <= $tendTime) {  
                    $zxm_ads .= '<a href="' . $turl . '" target="_blank" rel="nofollow" class="dh">'.$ttxt.'</a>';  
                }  
            }
            $zxm_ads .= '</div><script><!--纯文本广告滑块-->
                    jQuery(document).ready(function($) {  
                        var sliderSt = $(".txtguanggao");  
                        sliderSt.slick({  
                            dots: false,  
                            arrows: false,  
                            infinite: true,  
                            speed: 500,  
                            slidesToShow: ' .$slidesToShow .',  
                            vertical: false,
                            cssTransforms3d: true, // 启用3D变换效果  
                        });  
                        setInterval(function() {  
                            sliderSt.slick("slickNext");  
                        }, '.$speed.');
                    }); </script>';
        }
    }
    $zxm_ads .= '<style>
            
            .adb {  
              position: relative;  
              width: 100%; /* 根据您的需求设置容器的宽度 */  
              height: 150px; /* 根据您的需求设置容器的高度 */  
              overflow: hidden;  
            }  
              
            .adb img {  
              position: absolute;  
              top: 0;  
              left: 0;  
              width: 100%; /* 根据您的需求设置图片的宽度 */  
              height: 100%; /* 根据您的需求设置图片的高度 */  
              object-fit: none; /* 图片始终填充整个容器，同时保持原始的纵横比 */  
            }
            .ad {
                background: #fff;
                overflow: hidden;
                clear: both;
                border-radius: 6px;
                text-align: center; 
            }
            .ad a {
                margin: 5px;
                display: block;
                border-radius: 3px;
            }
            .ad img {
                max-width: 100%;
                display: block;  
                margin: 0 auto;
                max-height:150px;
                object-fit: contain;
                margin-bottom:2px;
            }
            .ad li {
                float: left;
                width: 50%;
                list-style: none;
                transform-style: preserve-3d; /* 保留3D变换效果 */
            }
            @media(max-width:999px) {
                .ad {
                    margin: 0 0 10px 0;
                }
            }

            .txtguanggao {
                width: 100%;
                overflow: hidden;
                display: block;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
            }
            .txtguanggao a {
                width: calc((100% - 20px) / 4);
                float: left;
                border-radius: 2px;
                line-height: 35.35px;
                height: 35.35px;
                text-align: center;
                font-size: 14px;
                color: #fff;
                display: inline-block;
                background-color: rgb(255, 153, 159);
                margin: 2.5px;
                transition-duration: .3s;
            }
            .txtguanggao a:nth-child(5n+1) {
                background-color: #dc3545;
            }
            .txtguanggao a:nth-child(5n+2) {
                background-color: #007bff;
            }
            .txtguanggao a:nth-child(5n+3) {
                background-color: #28a745;
            }
            .txtguanggao a:nth-child(5n+4) {
                background-color: #ffc107;
            }
            .txtguanggao a:nth-child(5n+5) {
                background-color: #6633cc;
            }
            .txtguanggao a:hover {
                background: #FF2805;
                color: #FFF
            }
            @media screen and (max-width: 1000px) {
                .txtguanggao a {
                    width: calc((100% - 10px) / 2);
                    float: left;
                    border-radius: 2px;
                    line-height: 35.35px;
                    height: 35.35px;
                    text-align: center;
                    font-size: 14px;
                    color: #fff;
                    display: inline-block;
                    background-color: rgb(255, 153, 159);
                    margin: 2.5px;
                    transition-duration: .3s;
                }
            }
            @media screen and (min-width: 1000px) {
                .txtguanggao a {
                    width: calc((100% - 20px) / 4);
                }
            }
        </style></div></div></div>';
    return $zxm_ads; // 返回HTML内容作为函数的输出  
}
?>
