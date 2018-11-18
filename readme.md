# About Payroll
Payroll is an application which helps companies determine the dates they need to pay salaries to their departments.

## The Application allows users to:

- Manage Monthly Salaries.
- Manage Employees

## What the application Can Do:

- Sales staff gets a monthly fixed base salary and a monthly bonus(calculated as 10% of the base salary as default but the admin can change this percentage for any employee).
- The base salaries are paid on the last day of the month unless that day is a Friday or a Saturday (weekend) -> payday will be the last weekday before the last day of the month.
- On the 15th of every month bonuses are paid for the previous month, unless 􏰀that day is a weekend. In that case: they are paid on the first Thursday after the 15th.

<hr>

<p><strong>Allowed HTTPs requests:-</strong></p>
<ul>
        <p><code>GET</code>     : Get a resource or list of resources</p>
        <p><code>POST</code>    : Create or Delete resource</p>
<!--         <p><code>PUT</code>     : Update resource</p> -->
</ul>
<p><strong>Description Of Usual Server Responses:-</strong></p>
<ul>
    <li>
        <p>200 <code>OK</code> - the request was successful (some API calls may return 201 instead).</p>
    </li>
    <li>
        <p>201 <code>Created</code> - the request was successful and a resource was created.</p>
    </li>
    <li>
        <p>204 <code>No Content</code> - the request was successful but there is no representation to return (i.e. the response is empty).</p>
    </li>
    <li>
        <p>400 <code>Bad Request</code> - the request could not be understood or was missing required parameters.</p>
    </li>
    <li>
        <p>401 <code>Unauthorized</code> - authentication failed or user doesn't have permissions for requested operation.</p>
    </li>
    <li>
        <p>403 <code>Forbidden</code> - access denied.</p>
    </li>
    <li>
        <p>404 <code>Not Found</code> - resource was not found.</p>
    </li>
    <li>
        <p>405 <code>Method Not Allowed</code> - requested method is not supported for resource.</p>
    </li>
</ul>

<hr>

<p><strong>User attributes:</strong></p>
<ul>
    <li>
        <p>id <code>(integer)</code> : unique|identifier|incremental.</p>
    </li>
    <li>
        <p>name <code>(String)</code> : Name.</p>
    </li>
    <li>
        <p>email <code>(String)</code> : Email|unique.</p>
    </li>
    <li>
        <p>password <code>(String)</code> : Password|Confirmed.</p>
    </li>
</ul>

<p><strong>Employee attributes:</strong></p>
<ul>
    <li>
        <p>id <code>(integer)</code> : unique|identifier|incremental.</p>
    </li>
    <li>
        <p>name <code>(String)</code> : Name.</p>
    </li>
    <li>
        <p>salary <code>(float)</code></p>
    </li>
    <li>
        <p>percentage <code>(float)</code></p>
    </li>
    <li>
        <p>total <code>(float)</code></p>
    </li>
</ul>
<hr>

<h1 class="resourceName">User</h1>
<p><strong>Registration.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/user/registration</p>
<p>Response</p>
<code>200</code>
<p>Create and Retrieve the New User's Data with The Token.</p>

<hr>
<p><strong>Login.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/user/login</p>
<p>Response</p>
<code>200</code>
<p>Attempt to Login and if the Credential (Email and Password) are Corect Retrieve The Token.</p>

<hr>
<p><strong>Logout.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/user/logout</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Delete Session And Retrieve a Message "Come Back Soon"</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<h1 class="resourceName">Employee</h1>
<p><strong>Retrieve list of All Employees.</strong></p>
<p><code>GET</code> : http://127.0.0.1:8000/api/employee</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Retrieve list of All Employees.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Show Single Employee.</strong></p>
<p><code>GET</code> : http://127.0.0.1:8000/api/employee/show/{id}</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Retrieve Selected Employee.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Create New Employee.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/employee/create</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Create and Retrieve the Employee.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Update Existed Employee and Salary (according to new data).</strong></p>
<p><code>PUT</code> : http://127.0.0.1:8000/api/employee/update/{id}</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Update the Selected Employee and Retrieve the new data of Employee.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Delete Employee.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/employee/delete/{id}</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Delete the selected Employee and Retrieve Success message "Employee deleted successfully".</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>


<hr>

<h1 class="resourceName">Salaries</h1>
<p><strong>Retrieve list of All Monthly Salaries.</strong></p>
<p><code>GET</code> : http://127.0.0.1:8000/api/salary</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Retrieve list of All Salary.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Show Single Salary Data.</strong></p>
<p><code>GET</code> : http://127.0.0.1:8000/api/salary/show/{id}</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Retrieve Selected Salary.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Create New Monthly Salary Sata.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/salary/create</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Create and Retrieve the Salary.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Update Existed Salary Data (according to new data).</strong></p>
<p><code>PUT</code> : http://127.0.0.1:8000/api/salary/update/{id}</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Update the Selected Salary and Retrieve the new data of Salary.</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>

<hr>

<p><strong>Delete Monthly Salary.</strong></p>
<p><code>POST</code> : http://127.0.0.1:8000/api/salary/delete/{id}</p>
<p>Response</p>
<div class="docs-request-headers"><h4 class="pm-h4">Headers</h4><table class="pm-table docs-request-table"><tbody><tr><td class="weight--medium">Content-Type</td><td>application/json</td></tr><tr><td class="weight--medium">Authorization</td><td>bearer {{token}}</td></tr></tbody></table></div>
<code>200</code>
<p>Delete the selected Salary and Retrieve Success message "Salary deleted successfully".</p>
<code>401</code>
<p>Retrieve error: Unauthenticated token.</p>
