
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">編輯看板內容</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="editModal-top-cancel-btn">
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="dish_id" id="dish_id" value="">
				<form class="kt-form" id="edit-form">
					<div class="form-group row">
						<div class="col-12 kt-align-center" style="background-color:#efefef">
							<label for="example-search-input" class="col-form-label">
								裝置：防災視訊室多螢幕輸出（21:9）
							</label>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-3 kt-align-right">
							<label for="example-search-input" class="col-form-label">
								版型
							</label>
						</div>
						<div class="col-9">
							<div class="kt-radio-inline">
								<label class="kt-radio">
									<input class="mr-1" type="radio" name="edition_type" value="default" checked/>預設版型
			                        <span></span>
								</label>
								<label class="kt-radio">
									<input class="mr-1" type="radio" name="edition_type" value="upload" />上傳圖片
			                        <span></span>
								</label>
							</div>
						</div>
					</div>
					<div class="js-display-block js-default" style="display:block;">
						<div class="form-group row">
							<div class="col-3 kt-align-right">
								<label for="example-search-input" class="col-form-label">
									人員1
								</label>
							</div>
							<div class="col-5">
								<select class="form-control" name="people_1">
									<option value="0" selected>不選擇人員</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-3 kt-align-right">
								<label for="example-search-input" class="col-form-label">
									人員2
								</label>
							</div>
							<div class="col-5">
								<select class="form-control" name="people_2">
									<option value="0" selected>不選擇人員</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-3 kt-align-right">
								<label for="example-search-input" class="col-form-label">
									本場次記者會
								</label>
							</div>
							<div class="col-4">
								<select class="form-control js-news-status" name="news_status">
									<option value="1">啟用</option>
									<option value="2" selected>停用</option>
								</select>
							</div>
							<div class="col-5">
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="la la-clock-o"></i></span></div>
									<input type="text" class="form-control js-news" name="news_time" id="news-time" disabled data-format="hh:mm">
								</div>
							</div>

						</div>
						<div class="form-group row">
							<div class="col-3 kt-align-right">
								<label for="example-search-input" class="col-form-label">
									下場次記者會
								</label>
							</div>
							<div class="col-4">
								<select class="form-control js-news-status" name="next_news_status">
									<option value="1">啟用</option>
									<option value="2" selected>停用</option>
								</select>
							</div>
							<div class="col-5">
                                <div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="la la-clock-o"></i></span></div>
									<input type="text" class="form-control js-news" name="news_time" id="next-news-time" disabled data-format="hh:mm">
								</div>
							</div>
						</div>
					</div>

					<div class="js-display-block js-upload" style="display:none;">
						<div class="form-group row">
							<div class="col-3 kt-align-right">
								<label for="example-search-input" class="col-form-label">
									上傳檔案
								</label>
							</div>
							<div class="col-8">
								<div class="col-3">
									<label for="file-upload-avatar" class="custom-file-upload">
										<i class="la la-cloud-upload" style="font-size:24px"></i>
									</label>
									<input type="file"  class="upload-image"
										   id="file-upload-avatar"
										   accept="image/gif, image/jpeg, image/png" style="display:none;"/>
									<span class="image_name"></span>
								</div>
								<span><i class="la la-exclamation-circle"></i>圖片尺寸為 1320px*790px，不超過100KB。</span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="editModal-cancel-btn">取消</button>
				<button type="button" class="btn btn-primary" id="edit-submit-btn">確認</button>
			</div>
		</div>
	</div>
</div>
