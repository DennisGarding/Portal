import axios from "axios";

const createLinkCategory = function (category) {
  // TODO: REMOVE AFTER DEBUG
  console.log("createLinkCategory", category);
  // TODO: REMOVE AFTER DEBUG
    return axios.post("/api/link/category/create", category).then((response) => {
        return response.data;
    }).catch((error) => {
        return Promise.reject(error.response.data);
    });
}

export default {
  createLinkCategory,
}
