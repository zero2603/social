import React, { Component } from 'react';
import {Link} from 'react-router-dom';
import {seCookie, setCookie} from '../../helper/cookie';

class CafeCard extends Component {
    
    render() {
        const {agency,className} = this.props;

        return (
            <div className={className}>
                <div>
                    <Link to={`/cafe/${agency.id}/view`}>
                        <img src={agency.avatar}/>
                    </Link>
                    <div className="image-card-btn cafe-btn">
                        <Link to={{pathname:"/dating/create", state: {cafe: agency}}}>
                            <button className="btn btn-sm">Hẹn hò</button>
                        </Link>
                        <Link to=''>
                            <button className="btn btn-sm btn-booking">Đặt chỗ</button>
                        </Link>
                    </div>
                </div>
                <div className="row image-card-content">
                    <div className="container">
                        <Link to={`cafe/${agency.id}/view`}>
                            <h5>
                                {agency.name}
                            </h5>
                        </Link>
                        <small>
                            {agency.address}
                        </small>
                    </div>
                </div>
            </div>
        );
    }
}

export {CafeCard};