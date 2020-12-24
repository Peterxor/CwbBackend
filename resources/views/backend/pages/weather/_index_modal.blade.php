
<div class="modal fade" id="index-modal" tabindex="-1" role="dialog" aria-labelledby="" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">管理分類</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
			<form class="kt-form kt-form--label-right" id="edit-form">
				<div class="row">
			        <div class="kt-portlet">
			            <div class="kt-portlet__body">
			                <table id="category-table" class="table table-sm table-head-bg-brand">
			                    <thead>
			                        <tr>
			                            <th>排序</th>
			                            <th>名稱</th>
			                            <th>操作</th>
			                        </tr>
			                    </thead>
								<tbody id="category_body">

								</tbody>
			                </table>

							<div class="kt-datatable__pager kt-datatable--paging-loaded">
				                <button type="button" class="btn btn-secondary" id="add-category-btn"><i class="la la-plus-square"></i>新增分類</button>
				            </div>
			            </div>
			        </div>
			    </div>
		     </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-btn">取消</button>
				<button type="button" class="btn btn-primary" id="edit-btn">儲存變更</button>
			</div>
		</div>
	</div>
</div>
