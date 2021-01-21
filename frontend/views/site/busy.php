<style>
    h1 {
        text-align: center;
    }
    #list {
        display: flex;
        flex-direction: column;
    }
    .row {
        display: flex;
    }
    .row-delete {
        margin-left: auto;
    }
</style>
<script>
    window.loadBusiness = function () {
        res = [];
        var length = localStorage.getItem('length');
        if(isNaN(length))
            return res;
        for(var i=0; i<length; i++) {
            var name = localStorage.getItem('name' + i);
            res[res.length] = {
                name: localStorage.getItem('name' + i),
                checked: localStorage.getItem('checked' + i) == 'true'
            };
        }
        return res;
    }
    window.saveBusiness = function (res) {
        localStorage.setItem('length', 0);
        for(var i=0; i<res.length; i++) {
            localStorage.setItem('name'+i, res[i].name);
            localStorage.setItem('checked'+i, res[i].checked);
        }
        localStorage.setItem('length', res.length);
    }
    window.checkedBusiness = function (i, checked) {
        var res = loadBusiness();
        res[i].checked = checked;
        saveBusiness(res);
    };
    window.updateBusiness = function () {
        var res = loadBusiness();

        list.innerHTML = "";

        for(var i=0; i<res.length; i++) {

            var el = document.createElement('input');
            el.type = 'checkbox';
            el.className = 'row-checkbox';
            el.setAttribute('onclick', 'window.checkedBusiness('+i+', this.checked)');
            el.checked = res[i].checked;

            var lb = document.createElement('label');
            lb.setAttribute('for', 'name'+i);
            lb.className = 'row-label';
            lb.textContent = res[i].name;

            var bt = document.createElement('input');
            bt.type = 'button';
            bt.className = 'row-delete';
            bt.value = "Удалить"
            bt.setAttribute('onclick', 'window.deleteBusiness('+i+')');

            var div = document.createElement('div');
            div.classList = 'row';

            div.append(el);
            div.append(lb);
            div.append(bt);

            list.append(div);
        }
    }
    window.appendBusiness = function () {

        var name = prompt('Введите название дела', '');

        if(!name || name == '')
            return;

        var res = loadBusiness()
        
        res[res.length] = {
            name: name,
            checked: false
        };

        saveBusiness(res);
        updateBusiness();
    }
    window.deleteBusiness = function (i) {
        var res = loadBusiness()

        res.splice(i,1);

        saveBusiness(res);
        updateBusiness();
    }

    window.onload = updateBusiness;

</script>

<h1> Списька дел </h1>

<div id="list">
</div>

<input type='button' value="Добавить дело" onclick="window.appendBusiness()" />

