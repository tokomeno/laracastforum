// let user = window.App.user
// let authorization = {
// 	updateReply(reply){
// 		return user.id == reply.user_id
// 	}
// }

// module.exports = authorization

let user = window.App.user;
 module.exports = {
    updateReply (reply) {
        return reply.user_id === user.id;
    }

    updateThread(thread){
    	return thread.user_id == user.id
    }
};
