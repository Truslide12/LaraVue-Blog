<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category List <Button @click="addModal=true"><Icon type="md-add" />Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
                                <th>Icon Image</th>
								<th>Category Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categoryLists" :key="i"
                            >
                            <!-- v-if="categorys.length" -->
								<td>{{category.id}}</td>
                                <td class="table_pro_img">
                                    <img :src="category.iconImage"/>
                                </td>
								<td class="_table_name">{{category.categoryName}}</td>
								<td>{{category.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(category, i)" :loading="category.isDeleting" >Delete</Button>
									<!-- -->
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
export default {
	data() {
		return {
			data : {
                categoryName: '',
                iconImage: '',
			},
			addModal : false,
			editModal: false,
            isAdding : false,
            isEditing: false,
			categoryLists : [],
			editData : {
                categoryName: '',
                iconImage: '',
			},
			index : -1,
			isDeleting : false,
			showDeleteModal: false,
			deleteItem: {},
            deletingIndex: -1,
            token: '',
            isIconImageNew: false,
            isEditingItem: false,
		}
	},

	methods : {
		async add() {
            if(this.data.categoryName.trim()=='') return this.e('Category name is required')
            if(this.data.iconImage.trim()=='') return this.e('Icon image is required')
            this.data.iconImage = `/uploads/${this.data.iconImage}`
			const res = await this.callApi('post', 'app/create_category', this.data)
			if(res.status===201){
				this.categoryLists.unshift(res.data)
				this.s('Category has been added successfully!')
				this.addModal = false
                this.data.categoryName = ''
                this.data.iconImage = ''
			} else {
				if(res.status==422) {
					if (this.res.errors.categoryName){
						this.i(res.data.errors.categoryName[0])
                    }
                    if (this.res.data.errors.iconImage){
						this.i(res.data.errors.iconImage[0])
                    }
				}else {
					this.swr()
				}
			}
		},
		async edit() {
            if(this.editData.categoryName.trim()=='') return this.e('Category name is required')
            if(this.editData.iconImage.trim()=='') return this.e('Icon image is required')
			const res = await this.callApi(
				'post',
				'app/edit_category',
				this.editData
			);
			if(res.status===200){
                this.categoryLists[this.index].categoryName = this.editData.categoryName
                this.categoryLists[this.index].iconImage = this.editData.iconImage
				this.s('Category has been added successfully!')
				this.editModal = false
			} else {
				if(res.status==422) {
					if (this.res.errors.categoryName){
						this.i(res.data.errors.categoryName[0])
					}
				}
				else {
					this.swr()
				}
			}
        },

		showEditModal (category, index) {
			console.log(category)
			this.editData = category
			this.editModal = true
            this.index = index
            this.isEditingItem = true
		},

		async delete() {
			// How to set a new attribute that was not loaded initially
			// this.$set(category, 'isDeleting', true)
			this.isDeleting = true
			const res = await this.callApi('post', 'app/delete_category', this.deleteItem)
			if(res.status===200){
				this.categoryLists.splice(this.deletingIndex, 1) // this will splice the list at i and remove it from the list on the front end
				this.s('category has been deleted successfully')
			} else {
				this.swr()
			}
			this.showDeleteModal = false
			this.isDeleting = false
		},

		showDeletingModal (category, i) {
			this.deleteItem = category
			this.deletingIndex = i
			this.showDeleteModal = true
        },

        handleSuccess (res , file) {
			res = `/uploads/${res}`;
            if(this.idEditingItem) {
                return (this.editData.iconImage = res);
            }
            this.editData.iconImage = res
        },

        handleError (res, file) {
            // console.log('res', res)
            // console.log('file', file)
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: "${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}"
            })
        },

        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png'
            })
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File' + file.name + ' is too large, please limit file size to no more than 2M',
            })
        },

        async deleteImage(isAdd=true) {
			let image;
            if(!isAdd){
                this.isIconImageNew = true
                let image = this.editData.iconImage
                this.editData.iconImage = ''
                this.$refs.editDataUploads.clearFiles()
            } else {
                let image = this.data.iconImage
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            }
            const res = await this.callApi('post', 'app/delete_image', {imageName: image})
            if(res.status != 200) {
                this.data.iconImage = image
                this.swr()
            }
		},
		closeEditModal () {
			this.isEditingItem = false;
			this.editModal = false;
		}
	},

	async created() {
        this.token = window.Laravel.csrfToken
		const res = await this.callApi('get', 'app/get_category')
		if(res.status===200){
			this.categoryLists = res.data
		} else {
			this.swr(error)
		}
	},
}

</script>
