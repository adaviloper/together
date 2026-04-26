import ListOrganizations from './ListOrganizations'
import CreateOrganization from './CreateOrganization'
import ViewOrganization from './ViewOrganization'
import EditOrganization from './EditOrganization'

const Pages = {
    ListOrganizations: Object.assign(ListOrganizations, ListOrganizations),
    CreateOrganization: Object.assign(CreateOrganization, CreateOrganization),
    ViewOrganization: Object.assign(ViewOrganization, ViewOrganization),
    EditOrganization: Object.assign(EditOrganization, EditOrganization),
}

export default Pages