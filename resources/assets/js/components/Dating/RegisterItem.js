import React, { Component } from 'react';
import {Link} from 'react-router-dom';
import {SquareAvatar} from '../Avatar';
import CircleButton from '../Button/CircleButton';
import connect from 'react-redux/es/connect/connect';
import Fragment from 'react-dot-fragment';
import InformationNumber from '../Information/InformationNumber';
 
class RegisterItem extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoved: parseInt(props.user.is_loved) ? true : false,
            isLiked: parseInt(props.user.is_like) ? true : false, 
            loveNumber: parseInt(props.user.loveNumber),
            likeNumber: parseInt(props.user.likeNumber),
            isSecret: props.isSecretEvent && !(props.user.is_partner_loved && props.user.is_loved) // 2 person is couple if they love each other
        }
    }

    onUpdateRelationship(actionType) {
        var data = {};

        if(actionType == 'love') {
            if(this.state.isLoved) {
                data = {'is_loved': 0};
                this.setState({
                    isLoved: false,
                    loveNumber: this.state.loveNumber - 1,
                    isSecret: this.props.isSecretEvent && !(this.props.user.is_partner_loved && false)
                });
            } else {
                data = {'is_loved': 1};
                this.setState({
                    isLoved: true,
                    loveNumber: this.state.loveNumber + 1,
                    isSecret: this.props.isSecretEvent && !(this.props.user.is_partner_loved && true)
                });
            }
        } else if(actionType == 'like') {
            if(this.state.isLiked) {
                data = {'is_like': 0};
                this.setState({
                    isLiked: false,
                    likeNumber: this.state.likeNumber - 1,
                });
            } else {
                data = {'is_like': 1};
                this.setState({
                    isLiked: true,
                    likeNumber: this.state.likeNumber + 1,
                });
            }
        }

        this.props.action(data, this.props.user.id);
    }

    render() {
        const {user, current_user, type} = this.props; 

        console.log(this.state)

        return (
            <div className="row register-item">
                <div className="col-1">
                    {
                        (user.id !== current_user.id) ? (
                            <span onClick={() => this.onUpdateRelationship('love')} className={`love-btn ${this.state.isLoved ? 'active' : ''}`}>
                                <i className={`fas fa-heart`} ></i>
                            </span>
                        ) : null
                    }
                </div>
            {
                (!this.state.isSecret || (user.id === current_user.id)) ? (
                    <Fragment>
                        <div className="col-3">
                            <Link to={`/profile/${user.id}`}>
                                <SquareAvatar img={user.avatar} size="large"></SquareAvatar>
                            </Link>
                        </div>
                        <div className="col-8">
                            <Link to={`/profile/${user.id}`}>
                                <h5>{user.name}</h5>
                            </Link>
                            
                            {
                                (user.id === current_user.id) ? (
                                    <Fragment>
                                        {
                                            (type == 'creator') ? (
                                                <div>
                                                    Bạn có thể hủy hẹn nếu không thể tổ chức cuộc hẹn này. Bạn sẽ bị phạt 100k
                                                    nếu hủy trước thời điểm chốt đăng ký. Sau thời điểm chốt, bạn sẽ bị phạt 200k.
                                                    Và nếu bạn không hủy hẹn mà không tổ chức thì chúng tôi sẽ không cho phép bạn tạo cuộc hẹn nữa!
                                                </div>
                                            ) : (
                                                <div>{user.address}</div>
                                            )
                                        }
                                    </Fragment>
                                ) : (
                                    <Fragment>
                                        {
                                            (type == 'creator') ? (
                                                <div>{user.address}</div>
                                            ) : (
                                                <div>
                                                    <div>{user.address}</div>
                                                    {
                                                        this.state.isLoved ? (
                                                            <p>Bạn thích <b>{user.name}</b>. Hãy nhắn tin và hẹn đôi với anh ấy!</p>
                                                        ) : null
                                                    }
                                                    <div>
                                                        <CircleButton
                                                            icon="fas fa-heart"
                                                            color={this.state.isLoved ? '#e74c3c' : '#34495e'}
                                                            action={() => this.onUpdateRelationship('love')}
                                                        ></CircleButton>
                                                        <CircleButton
                                                            icon="fas fa-thumbs-up"
                                                            color={this.state.isLiked ? '#2980b9' : '#34495e'}
                                                            action={() => this.onUpdateRelationship('like')}
                                                        ></CircleButton>
                                                        <CircleButton
                                                            icon="fas fa-comments"
                                                            color='#34495e'
                                                        // action
                                                        ></CircleButton>
                                                    </div>
                                                </div>
                                            )
                                        }
                                    </Fragment>
                                )
                            }
                        </div>
                    </Fragment>
                ) : (
                    <Fragment>
                        <div className="col-3">
                            <SquareAvatar img={`${baseUrl}/public/images/default-avatar-heart.png`} size="large"></SquareAvatar>
                        </div>
                        <div className="col-8">
                            <h5>{`ID-${user.id}`}</h5>
                            {/* <div>{user.address}</div> */}
                            <InformationNumber heartNumber={this.state.loveNumber} likeNumber={this.state.likeNumber} viewNumber={user.viewNumber}/>
                        </div>
                    </Fragment>
                )
            }
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        current_user: state.user.current_user
    }
}

export default connect(mapStateToProps, null)(RegisterItem);