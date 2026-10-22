@verbatim
  <div class="endpoint" id="ep-hr-employees-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/employees</code>
      <span class="endpoint-name">List employees</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists employees for the business, alphabetically by full name, with department and job title eager-loaded. Also returns total counts by employment type. Returns zeroed counts if the hr_employees table is not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 5,
      "name": "Nimal Perera",
      "employee_id": "EMP-005",
      "employment_type": "full_time",
      "type_label": "Full Time",
      "department": "Operations",
      "department_id": 2,
      "job_title": "Floor Supervisor",
      "job_title_id": 3,
      "basic_salary": 120000.0,
      "basic_salary_fmt": "120,000.00",
      "date_of_joining": "2024-03-01",
      "phone_number": "+94771234567"
    }
  ],
  "total_count": 18,
  "full_time_count": 14,
  "part_time_count": 3,
  "contract_count": 1
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-hr-employees-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/employees</code>
      <span class="endpoint-name">Create an employee</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new employee record. To reference a department or job title that doesn't exist yet, pass the literal value "__new__" for department_id / job_title_id along with new_department_name / new_job_title_name — the record is created inline within the same transaction. The declared salary must equal basic_salary (allowances are not supported via this endpoint).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_employees permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>full_name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>date_of_birth</td><td class="param-type">date</td><td>Must be before today.</td></tr>
            <tr><td>nic_passport_number</td><td class="param-type">string</td><td>Max 64 chars, unique per business.</td></tr>
            <tr><td>permanent_address</td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>current_address</td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>phone_number</td><td class="param-type">string</td><td>Max 40 chars.</td></tr>
            <tr><td>personal_email</td><td class="param-type">string</td><td>Valid email, max 255 chars.</td></tr>
            <tr><td>employee_id</td><td class="param-type">string</td><td>Max 64 chars, unique per business.</td></tr>
            <tr><td>job_title_id</td><td class="param-type">string</td><td>Existing job title id, or "__new__" with new_job_title_name.</td></tr>
            <tr><td>new_job_title_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Required when job_title_id is "__new__".</td></tr>
            <tr><td>department_id</td><td class="param-type">string</td><td>Existing department id, or "__new__" with new_department_name.</td></tr>
            <tr><td>new_department_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Required when department_id is "__new__".</td></tr>
            <tr><td>date_of_joining</td><td class="param-type">date</td><td></td></tr>
            <tr><td>employment_type</td><td class="param-type">string</td><td>One of the values in Employee::EMPLOYMENT_TYPES (e.g. full_time, part_time, contract).</td></tr>
            <tr><td>basic_salary</td><td class="param-type">number</td><td>0 to 999999999.99.</td></tr>
            <tr><td>salary</td><td class="param-type">number</td><td>Must equal basic_salary (within 0.02).</td></tr>
            <tr><td>emergency_contact_name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>emergency_contact_relationship</td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>emergency_contact_phone</td><td class="param-type">string</td><td>Max 40 chars.</td></tr>
            <tr><td>bank_account_holder_name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>bank_id</td><td class="param-type">integer</td><td>Must exist in the banks table.</td></tr>
            <tr><td>bank_branch</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>bank_account_number</td><td class="param-type">string</td><td>Max 64 chars.</td></tr>
            <tr><td>epf_number<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 80 chars.</td></tr>
            <tr><td>etf_number<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 80 chars.</td></tr>
            <tr><td>tax_tin<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 80 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 19,
    "name": "Kamala Silva",
    "employee_id": "EMP-019",
    "employment_type": "full_time",
    "type_label": "Full Time",
    "department": "Marketing",
    "department_id": 5,
    "job_title": "Marketing Executive",
    "job_title_id": 9,
    "basic_salary": 95000.0,
    "basic_salary_fmt": "95,000.00",
    "date_of_joining": "2026-07-31",
    "phone_number": "+94779876543",
    "personal_email": "kamala.silva@example.com",
    "permanent_address": "12 Galle Road, Colombo",
    "epf_number": null,
    "etf_number": null
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Monthly gross must equal basic salary (no allowances supported via API).",
  "errors": { "salary": ["Monthly gross must equal basic salary (no allowances supported via API)."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-hr-employees-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/employees/{employee}</code>
      <span class="endpoint-name">Get employee detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single employee's detail, including personal email, permanent address, and EPF/ETF numbers not present on the list endpoint. Returns 404 if the employee does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "name": "Nimal Perera",
    "employee_id": "EMP-005",
    "employment_type": "full_time",
    "type_label": "Full Time",
    "department": "Operations",
    "department_id": 2,
    "job_title": "Floor Supervisor",
    "job_title_id": 3,
    "basic_salary": 120000.0,
    "basic_salary_fmt": "120,000.00",
    "date_of_joining": "2024-03-01",
    "phone_number": "+94771234567",
    "personal_email": "nimal.perera@example.com",
    "permanent_address": "45 Kandy Road, Kurunegala",
    "epf_number": "EPF-1122",
    "etf_number": "ETF-1122"
  }
}</code></pre>
      </div>
@endverbatim
