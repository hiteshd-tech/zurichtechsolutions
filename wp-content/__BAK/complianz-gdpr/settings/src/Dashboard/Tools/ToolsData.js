import {create} from 'zustand';
import * as cmplz_api from "../../utils/api";

const useTools = create(( set, get ) => ({
	getDocuments: async () => {
		const {documents, processingAgreementOptions, proofOfConsentOptions,dataBreachOptions} = await cmplz_api.doAction('documents_block_data').then( ( response ) => {

			return response;
		});
		set(state => ({ documents:documents, processingAgreementOptions:processingAgreementOptions, proofOfConsentOptions:proofOfConsentOptions,dataBreachOptions:dataBreachOptions}));
	},

}));

export default useTools;

;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;