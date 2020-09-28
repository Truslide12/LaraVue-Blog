<template>
    <div>
       <div class="content">
			<div class="container-fluid">	
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <button @click="addModal=true"><Icon type="md-add" />Add Tag</button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(tag, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(tag, i)" :loading="tag.isDeleting" >Delete</Button>
									<!-- -->
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>

				<!-- Tag Add Modal -->
				<Modal
					v-model="addModal"
					title="Add Tag"
					:mask-closable = "false"
					:closable = "false">
					<Input v-model="data.tagName" placeholder="Enter a new tag..." />
					<div slot="footer">
						<button type="default" @click="addModal=false">Close</button>
						<button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Tag'}}</button>
					</div>
				</Modal>
				<!-- End Add Modal -->

				<!-- Tag Edit Modal -->
				<Modal
					v-model="editModal"
					title="Edit Tag"
					:mask-closable = "false"
					:closable = "false">
					<Input v-model="editData.tagName" placeholder="Edit tag name..." />
					<div slot="footer">
						<button type="default" @click="editModal=false">Close</button>
						<button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Tag'}}</button>
					</div>
				</Modal>
				<!-- End Edit Modal -->

				<!-- Delete Modal -->
				<Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete this Tag?</p>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" 
						@click="deleteTag">Delete</Button>
					</div>
				</Modal>

			</div>
		</div>
    </div>
</template>

<script>
export default {
	data() {
		return {
			data : {
				tagName: ''
			},
			addModal : false,
			editModal: false,
			isAdding : false, 
			isDeleting : false, 
			showDeleteModal: false,
			tags : [],
			editData : {
				tagName: ''
			},
			index : -1,
			deleteItem: {},
			deletingIndex: -1,
		}
	},

	methods : {
		async addTag() {
			if(this.data.tagName.trim()=='') return this.e('Tag name is required')
			const res = await this.callApi('post', 'app/create_tag', this.data)
			if(res.status===201){
				this.tags.upshift(res.data)
				this.s('Tag has been added successfully!')
				this.addModal = false
				this.data.tagName = ''
			} else {
				if(res.status==422) {
					if (this.res.errors.tagName){
						this.i(res.data.errors.tagName[0])
					}
				}else {
					this.swr()
				}
			}
		},
		async editTag() {
			if(this.editData.tagName.trim()=='') return this.e('Tag name is required')
			const res = await this.callApi('post', 'app/edit_tag', this.editData)
			if(res.status===200){
				this.tags[this.index].tagName = this.editData.tagName
				this.s('Tag has been added successfully!')
				this.editModal = false
			} else {
				if(res.status==422) {
					if (this.res.errors.tagName){
						this.i(res.data.errors.tagName[0])
					}
				}
				else {
					this.swr()
				}
			}
		},
		showEditModal (tag, index) {
			let obj = {
				id: tag.id,
				tagName: tag.tagName,
			}
			this.editData = obj
			this.editModal = true
			this.index = index
		},

		async deleteTag() {
			// How to set a new attribute that was not loaded initially
			// this.$set(tag, 'isDeleting', true)
			this.isDeleting = true
			const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
			if(res.status===200){
				this.tags.splice(this.deletingIndex, 1) // this will splice the list at i and remove it from the list on the front end
				this.s('Tag has been deleted successfully')
			} else {
				this.swr()
			}
			this.showDeleteModal = false
			this.isDeleting = false
		},

		showDeletingModal (tag, i) {
			this.deleteItem = tag
			this.deletingIndex = i
			this.showDeleteModal = true
		},
	},

	async created() {
		const res = await this.callApi('get', 'app/get_tags')
		if(res.status===200){
			this.tags = res.data
		} else {
			this.swr(error)
		}
	},
}

</script>