<div class="col-sm-3 col-md-3">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file">
                            </span> Products</a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <a href="{{ URL::to('admin/products/add') }}">Add</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ URL::to('admin/products/view') }}">View</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-user">
                            </span> Users</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <a href="{{ URL::to('admin/users/add') }}">Add</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ URL::to('admin/users/view') }}">View</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>