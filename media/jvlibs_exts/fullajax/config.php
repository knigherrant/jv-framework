{
    name: 'Full Ajax',
    version: '1.0.0',
    config: {
        applys:{
            field: 'multi',
            label: 'Applys',
            item:{
				assign:{
					label: 'Assign at',
					field: 'input',
					value: 'body'
				},
				getfrom:{
					label: 'Get content from',
					field: 'input',
					value: 'body'
				},
				applyto:{
					label: 'Apply to',
					field: 'input',
					value: 'body'
				},
				deny:{
					label: 'Deny selector',
					field: 'select2',
					tags: [],
					tokenSeparators: ','
				},
				only:{
					label: 'Only selector',
					field: 'select2',
					tags: [],
					tokenSeparators: ',',
					
				},
				nocache:{
					label: 'No cache scripts (Regex)',
					field: 'select2',
					tags: [],
					tokenSeparators: ','
				},
				script: {
					label: 'Custom script',
					field: 'textarea',
					autoHeight: true
				}
			}
        }
    }
}