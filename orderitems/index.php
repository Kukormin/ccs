<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
if ($USER->IsAuthorized() && $USER->IsAdmin()) :?>
    <form action="excel.php">
        <p>
            <label for="status">Статус</label>
        </p>
        <p>

            <select id="status" size="10" name="status">
                <option value="client-confirmed">Согласование</option>
                <option selected value="complete">Выполнен</option>
                <option value="new">Новый</option>
                <option value="v-proizvodstve">В производстве</option>
                <option value="ozidanie-dostavki">Ожидание доставки</option>
                <option value="send-to-delivery">В доставке</option>
                <option value="no-call">Недозвон</option>
                <option value="dostavlen">Доставлен</option>
                <option value="assembling-complete">Укомплектован</option>
                <option value="obrabotan">Обработан</option>
                <option value="cancel-other">Отменен</option>
                <option value="zayavka">Заявка на производство</option>
                <option value="fail-delivery-date">Ошибка в день доставки</option>
                <option value="presale">Пресейл</option>
                <option value="prop-zv">Пропущенный звонок</option>
            </select>
        </p>
        <p><label for="date_from">С</label></p>
        <p>
            <input id="date_from" type="date" name="date_from" />
        </p>
        <p><label for="date_from">До</label></p>
        <p>
            <input id="date_to" type="date" name="date_to" value="<?php echo date("Y-m-d");?>" />
        </p>

        <p><input type="submit" value="получить"></p>
    </form>
<?endif;?>