<div class="card-body">
    <form action="{{ route('dashboard.categories.index') }}" method="get">
        <div class="row">
            <div class="col-2">
                <div class="from-group">
                    <select name="sort_by" class="form-control">
                        <option selected disabled value="">Sort By</option>
                        <option value="id">Id</option>
                        <option value="name">Name</option>
                        <option value="created_at">Created At</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="from-group">
                    <select name="order_by" class="form-control">
                        <option selected disabled value="">Order By</option>
                        <option value="asc">Acsending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-1">
                <div class="from-group">
                    <select name="limit_by" class="form-control">
                        <option selected disabled value="">Limit</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="from-group">
                    <select name="status" class="form-control">
                        <option selected disabled value="">Status </option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="from-group">
                    <input class="form-control" name="keyword" placeholder="Search Here...">
                </div>
            </div>
            <div class="col-1">
                <div class="from-group">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-category">
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.performance) {
            if (performance.navigation.type === 1) { // التحقق من عملية الـ Refresh
                const currentUrl = window.location.href;
                const baseUrl = "{{ route('dashboard.categories.index') }}";

                // تحقق مما إذا كان هناك Query Parameters
                if (currentUrl.includes('?')) {
                    window.location.href = baseUrl; // إعادة التوجيه للرابط الأساسي
                }
            }
        }
    });
</script>
