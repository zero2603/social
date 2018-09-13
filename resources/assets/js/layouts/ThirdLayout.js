import React, { Component } from 'react';
import LeftSidebar from '../components/LeftSidebar';

class ThirdLayout extends Component {
    render() {
        return (
            <div className="container">
                <div className="row">
                    <LeftSidebar></LeftSidebar>
                    <main className="col col-xl-10 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        {this.props.children}
                    </main>
                </div>
            </div>
        );
    }
}

export default ThirdLayout;