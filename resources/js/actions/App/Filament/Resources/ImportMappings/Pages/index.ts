import ListImportMappings from './ListImportMappings'
import CreateImportMapping from './CreateImportMapping'
import EditImportMapping from './EditImportMapping'

const Pages = {
    ListImportMappings: Object.assign(ListImportMappings, ListImportMappings),
    CreateImportMapping: Object.assign(CreateImportMapping, CreateImportMapping),
    EditImportMapping: Object.assign(EditImportMapping, EditImportMapping),
}

export default Pages