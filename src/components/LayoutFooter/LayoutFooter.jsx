import React from 'react';
import styles from './LayoutFooter.module.css';
import PropTypes from "prop-types";


// TODO use https://www.npmjs.com/package/react-fixed-bottom
// https://medium.com/turo-engineering/react-stick-to-bottom-accessible-safari-fixed-bottom-elements-9ed761fbeecb
function LayoutFooter(props) {
    let footerActions = null;

    if (props.actions) {
        footerActions = <div className={styles.layoutFooterActions}>
            {props.actions}
        </div>;
    }

    return (
        <div className={styles.layoutFooter}>
            <div className={styles.layoutFooterBody}>
                {props.children}
            </div>
            {footerActions}
        </div>
    );
}

LayoutFooter.propTypes = {
    actions: PropTypes.any
}

export default LayoutFooter
export {LayoutFooter}
