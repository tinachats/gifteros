<!-- Settings Sidebar -->
<div class="settings-bar">
    <div class="settings-header d-flex align-items-center justify-content-between box-shadow-sm p-2">
        <h2 class="font-600 lead lead-2x">Settings</h2>
        <i class="material-icons mr-2 toggle-settings">close</i>
    </div>
    <div class="container-fluid px-3 mt-2">
        <p class="mb-0 font-500 d-none" id="day-mode">
            <i class="fa fa-sun-o"></i> Toggle Day Mode
        </p>
        <p class="mb-0 font-500" id="night-mode">
            <i class="fa fa-moon-o"></i> Toggle Night Mode
        </p>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn theme-switch" id="darkmode" onchange="themeMode(this);">
            </div>
        </div>
        <hr class="w-100">
        <p class="mb-0 font-500">
            <i class="fa fa-exchange"></i> Change Currency
        </p>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn usd-currency" id="usd-currency" onchange="usdCurrency(this);" checked>
                <label class="form-check-label" for="usd">USD</label>
            </div>
        </div>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn zar-currency" id="zar-currency" onchange="zarCurrency(this);">
                <label class="form-check-label" for="zar-currency">ZAR</label>
            </div>
        </div>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn zwl-currency" id="zwl-currency" onchange="zwlCurrency(this);">
                <label class="form-check-label" for="zwl-currency">ZWL</label>
            </div>
        </div>
        <hr class="w-100">
        <p class="mb-0 font-500">
            <i class="fa fa-sort-alpha-asc"></i> Sort by Name
        </p>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn" id="name-asc">
                <label class="form-check-label" for="name-asc">Ascending</label>
            </div>
        </div>
        <hr class="w-100">
        <p class="mb-0 font-500">
            <i class="fa fa-sort-amount-asc"></i> Sort by Price
        </p>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn" id="ascending-prices" checked>
                <label class="form-check-label" for="ascending-prices">Ascending</label>
            </div>
        </div>
        <hr class="w-100">
        <p class="mb-0 font-500">
            <i class="fa fa-sort"></i> Sort by Orders
        </p>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn" id="trending" checked>
                <label class="form-check-label" for="trending">Trending</label>
            </div>
        </div>
        <div class="d-flex align-items-center mt-2">
            <div class="form-check toggle-switch">
                <input type="checkbox" class="form-check-input switch-btn" id="recent">
                <label class="form-check-label" for="recent">Recent</label>
            </div>
        </div>
    </div>
</div>
<!-- /.Settings -->