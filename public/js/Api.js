function Api()
{
    [native/code]
};

Api.ajaxSetup = function()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

Api.post = function(url, data, callback)
{

    Api.ajaxSetup();
    Api.showLoading();

    $.post( url, data, function(data) {
        try
        {
            callback(data);
        }
        catch(exception)
        {
            callback(ko.toJSON({status: 0, mensagem: 'Ocorreu um erro no retorno do serviço.'}));
        }
    })
    .fail(function($err)
    {
        if ($err.status == 422)
        {
            infoAlert.error([$err.responseJSON.description]);
            return;
        }
        infoAlert.error(['Ocorreu um erro na execução do serviço.']);
    })
    .always(function()
    {
        Api.hideLoading();
    });
}

Api.postImage = function(url, formData, callback) {
      
    Api.ajaxSetup();      
    Api.showLoading();

    $.ajax({
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function(data)
        {
            try
            {
                callback(data);
            }
            catch(exception)
            {
                callback(ko.toJSON({status: 0, mensagem: 'Ocorreu um erro no retorno do serviço.'}));
            }
        },
        error: function($err)
        {
            if ($err.status == 422)
            {
                infoAlert.error([$err.responseJSON.description]);
                return;
            }
            infoAlert.error(['Ocorreu um erro na execução do serviço.']);
        },
        complete: function()
        {
            Api.hideLoading();
        }
    });
};

Api.get = function(url, callback)
{
    $.get(url, callback)
    .fail(function()
    {
        infoAlert.error(['Ocorreu um erro na execução do serviço.']);
    })
    .always(function()
    {
    });
}

Api.groupList = function(list, groupedTotal)
{
    var groupedList = [],
        listTemp = [],
        count = 0;

    ko.utils.arrayForEach(list, function(item, i)
    {
        count ++;
        listTemp.push(item);

        if ((count % groupedTotal) == 0 || list.length == i+1)
        {
            groupedList.push(listTemp);
            count = 0;
            listTemp = [];
        } 
    });

    return groupedList;
}

Api.url = function(id)
{
    return repo_link+'/'+id+'/'+repo_token;
}

Api.showLoading = function()
{
    waitingDialog.show();
    // $('#modalLoading').modal('show');
}

Api.hideLoading = function()
{
    setTimeout(function(){ 
        // $('#modalLoading').modal('hide');
        waitingDialog.hide();
    }, 2000);
}