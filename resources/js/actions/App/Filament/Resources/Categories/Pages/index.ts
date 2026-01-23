import ListCategories from './ListCategories'
import CreateCategory from './CreateCategory'
import ViewCategory from './ViewCategory'
import EditCategory from './EditCategory'

const Pages = {
    ListCategories: Object.assign(ListCategories, ListCategories),
    CreateCategory: Object.assign(CreateCategory, CreateCategory),
    ViewCategory: Object.assign(ViewCategory, ViewCategory),
    EditCategory: Object.assign(EditCategory, EditCategory),
}

export default Pages