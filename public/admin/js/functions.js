const generate_child_row_for_user = row => {
    var html = '';
        html +='<div class="card"><div class="card-body table-responsive">';
        html += '<table class="table table-border table-striped">';
        html += `<thead>
                    <tr>
                        <th>Username</th>
                        <th>Avatar</th>
                        <th>Address</th>
                        <th>Sex</th>
                        <th>Last login</th>
                    </tr>
                </thead>`;
        html += `
                    <tbody>
                        <tr>
                            <td>${row.username}</td>
                            <td></td>
                            <td>${ row?.address?.address_line_1 === undefined ? '' : row?.address?.address_line_1 }</td>
                            <td>${row.sex == null ? '' : row.sex}</td>
                            <td>${row.last_login}</td>
                        </tr>
                    </tbody>
                `;
        html += '</table></div></div>';
        
    return html;
}