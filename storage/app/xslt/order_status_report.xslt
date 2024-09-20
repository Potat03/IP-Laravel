<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
            <table>
                <thead>
                    <tr>
                        <th>order id</th>
                        <th>customer id</th>
                        <th>delivery address</th>
                        <th>delivery method</th>
                        <th>tracking number</th>
                        <th>received</th>
                        <th>created at</th>
                        <th>updated at</th>
                        <th>time since update</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>
                    <xsl:for-each select="orderStatusReport/order">
                        <tr>
                            <td><xsl:value-of select="orderID"/></td>
                            <td><xsl:value-of select="customerID"/></td>
                            <td><xsl:value-of select="deliveryAddress"/></td>
                            <td><xsl:value-of select="deliveryMethod"/></td>
                            <td><xsl:value-of select="trackingNumber"/></td>
                            <td><xsl:value-of select="received"/></td>
                            <td><xsl:value-of select="createdAt"/></td>
                            <td><xsl:value-of select="updatedAt"/></td>
                            <td><xsl:value-of select="timeSinceUpdate"/></td>
                            <td><xsl:value-of select="status"/></td>

                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>
    </xsl:template>
</xsl:stylesheet>