// PhoneNumberInput.jsx
import React from 'react';
import PhoneInput from 'react-phone-input-2';
import 'react-phone-input-2/lib/style.css';

const PhoneNumberInput = ({ value, onChange }) => {
  return (
    <div className="phone-input">
      <label htmlFor="phone">Phone Number:</label>
      <PhoneInput
        country={'pt'} // default country
        preferredCountries={['pt','es']}
        enableSearch={true}
        value={value}
        onChange={onChange}
        prefix="+"
        inputStyle={{
          width: '100%',
          padding: '0px 50px',
          fontSize: '16px',
          borderRadius: '5px',
          border: '1px solid #ccc',
        }}
        containerStyle={{ marginTop: '10px' }}
      />
    </div>
  );
};

export default PhoneNumberInput;
