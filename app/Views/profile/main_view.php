<?= $this->include('profile/common/header_view'); ?>
<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

<div class="page-content">
    <div class="visits">
        <div class="visits__title title">Посещения</div>
        <div class="dates">
            <div class="dates__icon img-contain">
                <img src="<?= base_url(); ?>/assets/img/icons/date.svg" alt="">
            </div>
            <input type="text" data-range="true" data-multiple-dates-separator=" - " class="dates-field field datepicker-here" placeholder="Январь 2021">
        </div>
        <div class="visits__body">
            <div class="visits__schedule ">
                 <div id="VisitsGrafik" style="width: 100%; "></div>
            </div>
            <div class="visits__row">
                <div class="visits__coll">
                    <div class="visits__caption title">Пол</div>
                    <div class="visits__coll-box">
                        <div class="visits__coll-schedule img-contain">
                            <img src="<?= base_url(); ?>/assets/img/visits/img-small.svg" alt="">
                        </div>
                        <div class="visits__items">
                            <div class="visits__item">
                                <div class="visits__item-elips" style="background-color: #333333;"></div>
                                <div class="visits__item-caption">Мужчины</div>
                            </div>
                            <div class="visits__item">
                                <div class="visits__item-elips" style="background-color: #E3E6E9;"></div>
                                <div class="visits__item-caption">Женщины</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="visits__coll">
                    <div class="visits__caption title">Новые/повторные</div>
                    <div class="visits__coll-box">
                        <div class="visits__coll-schedule img-contain">
                            <img src="<?= base_url(); ?>/assets/img/visits/img-small.svg" alt="">
                        </div>
                        <div class="visits__items">
                            <div class="visits__item">
                                <div class="visits__item-elips" style="background-color: #333333;"></div>
                                <div class="visits__item-caption">Новые пользователи</div>
                            </div>
                            <div class="visits__item">
                                <div class="visits__item-elips" style="background-color: #E3E6E9;"></div>
                                <div class="visits__item-caption">Повторные пользователи</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var VisitsGrafik = LightweightCharts.createChart(document.getElementById('VisitsGrafik'), {
        height: 300
    });
    var Visits = VisitsGrafik.addLineSeries({
        color: '#333333',
        lineStyle: 0,
        lineWidth: 2,
        crosshairMarkerVisible: true,
        crosshairMarkerRadius: 6,
        lineType: 2,
    });
    VisitsGrafik.applyOptions({
        handleScroll: true,
        handleScale: false,
    });


    Visits.setData([
        <?php for ($i=1; $i < 25; $i++) { ?>
            {
                time: '2021-01-<?=$i?>',
                value: <?=rand(20, 100)?>
            },
        <?php } ?>
    ]);
    VisitsGrafik.timeScale().fitContent();

</script>
<?= $this->include('profile/common/footer_view'); ?>
