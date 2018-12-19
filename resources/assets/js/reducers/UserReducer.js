import {
    GET_CURRENT_USER,
    GET_CURRENT_USER_DETAIL,
    GET_USER_DETAIL,
    UPDATE_USER_DETAIL,
    UPDATE_RELATIONSHIP,
    GET_FRIENDS_LIKED_YOU,
    GET_FRIENDS_YOU_LIKED,
    GET_FRIENDS_VISITED,
    VERIFY_ID_CARD,
    GET_FEATURED_USER_PHOTOS
} from '../actions/types';

const INIT_STATE = {
    current_user: {},
    user: {},
    user_hobbies: [],
    other_user_data: {
        user: {
            hobbies: []
        },
        posts: [],
        relationship: {}
    },
    featured_photos: []
}

export default (state = INIT_STATE, action) => {
    switch(action.type) {
        case GET_CURRENT_USER: {
            return {...state, current_user: action.payload}
        }
        // when view other user profile
        case GET_USER_DETAIL: {
            return {...state, other_user_data: action.payload}
        }
        case GET_CURRENT_USER_DETAIL: {
            return {
                ...state, 
                user: action.payload.user, 
                user_hobbies: action.payload.hobbies, 
                relationship: action.payload.relationship
            }
        }
        // view current user profile
        case UPDATE_USER_DETAIL: {
            return {...state, user: action.payload}
        }
        case UPDATE_RELATIONSHIP: {
            return {...state}
        }
        case GET_FRIENDS_LIKED_YOU: {
            return {...state, friendsLikeYou: action.payload}
        }
        case GET_FRIENDS_YOU_LIKED: {
            return {...state, friendsYouLiked: action.payload}
        }
        case GET_FRIENDS_VISITED: {
            return {...state, friendsVisited: action.payload}
        }
        case VERIFY_ID_CARD: {
            return {...state};
        }
        case GET_FEATURED_USER_PHOTOS: {
            return {...state, featured_photos: action.payload}
        }
        default: {
            return {...state};
        }
    }
}