const pagination = {
	data: () => ({
		queryParams: {
			page: 1,
			per_page: 15
		},
		paginationData: {
			current_page: 1,
			per_page: 15,
			has_prev: false,
			has_next: true,
			total: 0,
			lastPage: 0
		}
	}),
	computed: {
		startPage() {
			if (this.paginationData.current_page <= 2) {
				return 1;
			} else if (
				this.paginationData.current_page >=
				this.paginationData.lastPage - 1
			) {
				if (this.paginationData.lastPage - 4 > 0) {
					return this.paginationData.lastPage - 4;
				} else {
					return 1;
				}
			} else {
				return this.paginationData.current_page - 2;
			}
		}
	},
	methods: {
		/**
		 * Converting pagination parameters from object to string
		 * @param {{page:[String,Number],per_page:[String,Number]}} objParams  pagination parameters (`page`, `per_page`)
		 */
		urlConstructor(objParams) {
			let result = "";
			for (let key in objParams) {
				result += `${key}=${objParams[key]}&`;
			}
			return result.slice(0, result.length - 1);
		},
		/**
		 * Change page to another.
		 * @param {[String,Number]} newPage A page number
		 */
		setPage(newPage) {
			this.queryParams.page = newPage;
		},
		/**
		 *
		 * @param {[Number,String]} value new value, for pagination
		 */
		setPerPage(value) {
			this.queryParams.per_page = value;
			this.queryParams.page = 1;
			this.openedPerPage = false;
		},
		/**
		 *  Method converted information from backend data into object
		 * @param {{current_page:[String,Number],per_page:[String,Number],total:[String,Number],last_page:[String,Number],next_page_url:String,prev_page_url:String}} data Object with pagination info
		 */
		setPaginationData(data) {
			const paginationData = {
				current_page: data.current_page,
				per_page: data.per_page,
				total: data.total,
				lastPage: data.last_page,
				has_next: data.next_page_url != null,
				has_prev: data.prev_page_url != null
			};
			return paginationData;
		}
	}
};
export default pagination;
