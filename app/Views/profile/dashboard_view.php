<?= $this->include('profile/common/header_view'); ?>
<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

<div class="page-content">
    <div class="loader"><img src="/assets/img/loader.gif" alt=""></div>
    <div class="visits">
        <div class="visits__title title">Посещения</div>
        <div class="flex">
            <?php if (!empty($companies)): ?>
                <div>
                    <div class="form__caption">Название компании</div>
                    <select class="form__field field companies-filter--js"  name="companies_id">
                        <?php foreach ($companies as $key => $value): ?>
                            <option value="<?=$value['id']?>"><?=$value['name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="dates">
                <div class="dates__icon img-contain">
                    <img src="<?= base_url(); ?>/assets/img/icons/date.svg" alt="">
                </div>
                <input type="text" data-range="true" data-multiple-dates-separator=" - " class="dates-field field datepicker-statistic" data-date-format="yyyy-mm-dd" placeholder="Январь 2021">
            </div>
        </div>

        <div class="visits__body">
            <div class="visits__schedule ">
                 <div id="VisitsGrafik" style="width: 100%; "></div>
            </div>
            <div class="visits__row">
                <div class="visits__coll">
                    <div class="visits__caption title">Пол</div>
                    <div class="visits__coll-box">
                        <div class="visits__items">
                            <div class="visits__item gender_0--js"  style="background-color: #c31111; width:0%;">
                                <div class="visits__item-caption"><span></span> | Не определен</div>
                            </div>
                            <div class="visits__item gender_1--js"  style="background-color: #010847; width:0%;">
                                <div class="visits__item-caption"><span></span> | Мужчины</div>
                            </div>
                            <div class="visits__item gender_2--js" style="background-color: #74058b; width:0%;">
                                <div class="visits__item-caption"><span></span> | Женщины</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="visits__coll">
                    <div class="visits__caption title">Новые/повторные</div>
                    <div class="visits__coll-box">
                        <div class="visits__coll-schedule img-contain">

                        </div>
                        <div class="visits__items">
                            <div class="visits__item attendance-new--js"  style="background-color: #213279;">
                                <div class="visits__item-caption"><span></span> | Новые пользователи</div>
                            </div>
                            <div class="visits__item  attendance-old--js"  style="background-color: #078d40;">
                                <div class="visits__item-caption"><span></span> | Повторные пользователи</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->include('profile/common/footer_view'); ?>
